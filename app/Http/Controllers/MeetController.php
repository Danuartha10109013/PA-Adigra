<?php

namespace App\Http\Controllers;

use App\Jobs\SendMeetEmailJob;
use App\Mail\DeleteMeetMail;
use App\Mail\EditMeetMail;
use App\Mail\MeetMail;
use App\Models\Meet;
use App\Models\User;
use App\Models\Absent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class MeetController extends Controller
{
    public function updateMeetingStatus()
{
    $now = \Carbon\Carbon::now();
    // $meetings = Meet::where('status', 'pending')->get();
    $meetings = Meet::whereIn('status', ['pending', 'onboarding'])->get();

    foreach ($meetings as $meet) {
        $start = \Carbon\Carbon::parse($meet->date . ' ' . $meet->start);
        $end = \Carbon\Carbon::parse($meet->date . ' ' . $meet->end);
            if($meet->acc == 1){
                if ($now->greaterThanOrEqualTo($start) && $now->lessThanOrEqualTo($end)) {
                    $meet->status = 'onboarding';
                    $meet->save();
                } elseif ($now->greaterThan($end)) {
                    $meet->status = 'completed';
                    $meet->save();
                }
            }
    }

    return response()->json(['message' => 'Status updated']);
}

    

    public function index()
    {
        $meets = Meet::with(['creator', 'participants'])->get();
        $users = User::all();
        // Ambil semua user yang sedang dalam meeting keluar kota yang belum selesai
        $usersInMeetingGlobal = collect();
        foreach ($meets as $meet) {
            if ($meet->category === 'out_of_town' && !in_array($meet->status, ['completed', 'cancelled'])) {
                $usersInMeetingGlobal = $usersInMeetingGlobal->merge($meet->participants->pluck('id'));
            }
        }
        // Untuk setiap meet, buat usersInMeetingEdit yang tidak berisi peserta dari meet itu sendiri
        foreach ($meets as $meet) {
            $meet->usersInMeetingEdit = $usersInMeetingGlobal->diff($meet->participants->pluck('id'))->values();
        }
        return view('backoffice.meet.index', compact('meets', 'users'));
    }

    public function create()
    {
        $users = User::all();
        
        // Ambil semua meeting keluar kota yang belum selesai
        $activeMeetings = Meet::where('category', 'out_of_town')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with('participants')
            ->get();
        
        // Ambil semua user yang sedang dalam meeting
        $usersInMeeting = collect();
        foreach ($activeMeetings as $meeting) {
            $usersInMeeting = $usersInMeeting->merge($meeting->participants->pluck('id'));
        }
        
        return view('backoffice.meet.index', compact('users', 'usersInMeeting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'start' => 'required',
            'end' => 'required',
            'category' => 'required|in:internal,online,out_of_town',
            'participants' => 'required_if:category,out_of_town|array'
        ]);

        // Cek konflik jadwal untuk meeting keluar kota
        if ($request->category === 'out_of_town' && $request->has('participants')) {
            $conflictUsers = [];
            
            foreach ($request->participants as $participantId) {
                // Cek apakah user sudah ada di meeting keluar kota yang belum selesai
                $existingMeeting = Meet::where('category', 'out_of_town')
                    ->whereNotIn('status', ['completed', 'cancelled'])
                    ->whereHas('participants', function($query) use ($participantId) {
                        $query->where('user_id', $participantId);
                    })
                    ->first();
                
                if ($existingMeeting) {
                    $user = User::find($participantId);
                    $conflictUsers[] = $user->name . ' (sedang dalam meeting: ' . $existingMeeting->title . ')';
                }
            }
            
            if (!empty($conflictUsers)) {
                return redirect()->back()
                    ->with('error', 'Tidak bisa menambahkan peserta berikut karena sedang dalam meeting: ' . implode(', ', $conflictUsers))
                    ->withInput();
            }
        }
        if(Auth::user()->role_id == 2){
            $acc = 0;
        }else{
            $acc = 1;
        }
        $meet = Meet::create([
            'title' => $request->title,
            'date' => $request->date,
            'start' => $request->start,
            'end' => $request->end,
            'category' => $request->category,
            'acc' => $acc,
            'created_by' => Auth::id()
        ]);

        if ($request->category === 'out_of_town' && $request->has('participants')) {
            $meet->participants()->attach($request->participants);
            
            // Buat record absensi dan rekapitulasi untuk setiap peserta
            foreach ($request->participants as $participantId) {
                // Buat record absensi (atau update jika sudah ada)
                $absent = Absent::firstOrNew([
                    'user_id' => $participantId,
                    'date' => $request->date,
                ]);

                $absent->fill([
                    'status' => 'Meeting Keluar Kota',
                    'description' => 'Meeting keluar kota: ' . $request->title,
                ])->save();

                // Buat record rekapitulasi absensi (atau update jika sudah ada)
                $summary = \App\Models\AttendanceSummary::firstOrNew([
                    'user_id' => $participantId,
                    'date' => $request->date,
                ]);

                 $summary->fill([
                    'is_leave' => true,
                    'leave_type' => 'Meeting Keluar Kota',
                    'notes' => 'Meeting keluar kota: ' . $request->title,
                    'check_in' => null, // Meeting keluar kota tidak memiliki jam masuk/pulang
                    'check_out' => null,
                    'is_late' => false,
                    'is_early_leave' => false,
                    'is_absent' => false,
                ])->save();
            }
        }

        return redirect()->back()->with('success', 'Meeting berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'start' => 'required',
            'end' => 'required',
            'category' => 'required|in:internal,online,out_of_town',
            'participants' => 'required_if:category,out_of_town|array'
        ]);

        // Cek apakah jadwal meeting sudah ada berdasarkan ID
        $meet = Meet::findOrFail($id);
        $oldMeet = Meet::findOrFail($id);

        // Cek konflik jadwal untuk meeting keluar kota
        if ($request->category === 'out_of_town' && $request->has('participants')) {
            $conflictUsers = [];
            
            foreach ($request->participants as $participantId) {
                // Cek apakah user sudah ada di meeting keluar kota yang belum selesai (kecuali meeting yang sedang diedit)
                $existingMeeting = Meet::where('category', 'out_of_town')
                    ->whereNotIn('status', ['completed', 'cancelled'])
                    ->where('id', '!=', $id) // Exclude meeting yang sedang diedit
                    ->whereHas('participants', function($query) use ($participantId) {
                        $query->where('user_id', $participantId);
                    })
                    ->first();
                
                if ($existingMeeting) {
                    $user = User::find($participantId);
                    $conflictUsers[] = $user->name . ' (sedang dalam meeting: ' . $existingMeeting->title . ')';
                }
            }
            
            if (!empty($conflictUsers)) {
                return redirect()->back()
                    ->with('error', 'Tidak bisa menambahkan peserta berikut karena sedang dalam meeting: ' . implode(', ', $conflictUsers))
                    ->withInput();
            }
        }

        // Update data meeting
        $meet->update([
            'title' => $request->title,
            'date' => $request->date,
            'start' => $request->start,
            'end' => $request->end,
            'category' => $request->category,
            'acc' => 0,
        ]);

        // Update peserta meeting jika kategori adalah out_of_town
        if ($request->category === 'out_of_town' && $request->has('participants') && count($request->participants) > 0) {
            // Hapus peserta lama
            $meet->participants()->detach();
            // Tambah peserta baru
            $meet->participants()->attach($request->participants);
            // Update record absensi dan rekapitulasi untuk setiap peserta
            foreach ($request->participants as $participantId) {
                // Update record absensi
                $absent = Absent::firstOrNew([
                    'user_id' => $participantId,
                    'date' => $request->date,
                ]);

                $absent->fill([
                    'status' => 'Meeting Keluar Kota',
                    'description' => 'Meeting keluar kota: ' . $request->title,
                ])->save();

                // Update record rekapitulasi absensi
                $summary = \App\Models\AttendanceSummary::firstOrNew([
                    'user_id' => $participantId,
                    'date' => $request->date,
                ]);

                 $summary->fill([
                    'is_leave' => true,
                    'leave_type' => 'Meeting Keluar Kota',
                    'notes' => 'Meeting keluar kota: ' . $request->title,
                    'check_in' => null,
                    'check_out' => null,
                    'is_late' => false,
                    'is_early_leave' => false,
                    'is_absent' => false,
                ])->save();
            }
        } else if ($request->category !== 'out_of_town') {
            // Jika bukan meeting keluar kota, hapus semua peserta
            $meet->participants()->detach();
        }

        // Ambil data karyawan di tabel user
        $karyawans = User::where('role_id', 2)->get();

        // Kirim email secara asynchronous tanpa menunggu
        foreach($karyawans as $karyawan)
        {
            Mail::to($karyawan->email)->queue(new EditMeetMail($meet, $oldMeet));
        }

        return redirect()->back()->with('success', 'Jadwal meet telah diupdate dan email telah dikirim.');
    }

    public function delete($id)
    {
        // Periksa apakah jadwal meeting ada
        $meet = Meet::findOrFail($id);

        // Hapus record Absent terkait jika meeting adalah 'out_of_town'
        if ($meet->category === 'out_of_town') {
            \App\Models\Absent::whereIn('user_id', $meet->participants->pluck('id'))
                               ->whereDate('date', $meet->date)
                               ->where('description', 'like', 'Meeting keluar kota: %' . $meet->title . '%') 
                               ->delete();
            
            // Hapus juga record AttendanceSummary terkait
             \App\Models\AttendanceSummary::whereIn('user_id', $meet->participants->pluck('id'))
                                        ->whereDate('date', $meet->date)
                                        ->where('leave_type', 'Meeting Keluar Kota')
                                        ->delete();
        }

        // Simpan data meeting sebelum dihapus
        $title = $meet->title;
        $date = $meet->date;
        $start = $meet->start;
        $end = $meet->end;

        // Ambil data karyawan dengan role_id 2
        $karyawans = User::where('role_id', 2)->get();

        // Kirim email pemberitahuan pembatalan ke setiap karyawan
        foreach($karyawans as $karyawan)
        {
            // Mail::to($karyawan->email)->queue(new DeleteMeetMail($title, $date, $start, $end));
        }

        // Hapus jadwal meeting setelah email terkirim
        $meet->delete();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Jadwal meeting berhasil dihapus dan notifikasi pembatalan telah dikirim ke karyawan.');
    }

    public function complete(Meet $meet)
    {
        try {
            // Update status meeting
            $meet->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);

            // Jika meeting adalah 'out_of_town', perbarui record Absent terkait
            if ($meet->category === 'out_of_town') {
                \App\Models\Absent::whereIn('user_id', $meet->participants->pluck('id'))
                                   ->whereDate('date', $meet->date)
                                   ->where('description', 'like', 'Meeting keluar kota: %' . $meet->title . '%')
                                   ->update([
                                       'status' => 'completed', // Ubah status di record Absent
                                       'description' => 'Meeting keluar kota (Selesai): ' . $meet->title // Perbarui deskripsi
                                   ]);
                 
                // Perbarui juga record AttendanceSummary terkait jika ada
                 \App\Models\AttendanceSummary::whereIn('user_id', $meet->participants->pluck('id'))
                                        ->whereDate('date', $meet->date)
                                        ->where('leave_type', 'Meeting Keluar Kota')
                                        ->update([
                                             'notes' => 'Meeting keluar kota (Selesai): ' . $meet->title // Perbarui notes
                                        ]);
            }

            return redirect()->back()->with('success', 'Meeting berhasil diselesaikan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function addNotulensi(Request $request, Meet $meet)
    {
        $request->validate([
            'notulensi' => 'required'
        ]);

        $meet->update([
            'notulensi' => $request->notulensi,
            'status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Notulensi berhasil ditambahkan');
    }

    public function accept(Meet $meet)
    {
        $meet->update([
            'acc' => 1
        ]);

        return redirect()->back()->with('success', 'Meeting berhasil diterima');
    }

    public function reject(Meet $meet)
    {
        $meet->update([
            'acc' => 2
        ]);

        return redirect()->back()->with('success', 'Meeting berhasil ditolak');
    }
}
