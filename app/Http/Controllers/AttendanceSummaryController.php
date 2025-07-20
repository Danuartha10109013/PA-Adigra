<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSummary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceSummaryController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua data AttendanceSummary yang difilter, termasuk data meeting keluar kota yang mungkin sudah ada di DB
        $summariesFromDb = AttendanceSummary::with('user')
            ->when($request->filled('start_date'), function ($q) use ($request) {
                return $q->whereDate('date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                return $q->whereDate('date', '<=', $request->end_date);
            })
            ->when($request->filled('user_id'), function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            })
            ->orderBy('date', 'desc')
            ->get();

        $users = User::all();

        // Ambil data meeting keluar kota yang difilter (untuk memastikan semua meeting terkait terambil)
        $meetings = \App\Models\Meet::with(['participants'])
            ->where('category', 'out_of_town')
            ->where('status', '!=', 'cancelled')
            ->when($request->filled('start_date'), function ($q) use ($request) {
                return $q->whereDate('date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                return $q->whereDate('date', '<=', $request->end_date);
            })
            ->when($request->filled('user_id'), function ($q) use ($request) {
                return $q->whereHas('participants', function($query) use ($request) {
                    $query->where('user_id', $request->user_id);
                });
            })
            ->get();

        // Proses dan gabungkan data: prioritas Meeting Keluar Kota
        $finalSummaries = collect();

        // Tambahkan semua data dari database (termasuk meeting yang sudah ada) ke koleksi final
        foreach ($summariesFromDb as $summary) {
             // Pastikan date adalah objek Carbon sebelum diformat
             $date = \Carbon\Carbon::parse($summary->date);
             $key = $summary->user_id . '_ மட்டு்ர _' . $date->format('Y-m-d');
             $finalSummaries->put($key, $summary);
        }

        // Timpa atau tambahkan data meeting keluar kota ke koleksi final
        foreach ($meetings as $meeting) {
            foreach ($meeting->participants as $participant) {
                // Pastikan date adalah objek Carbon sebelum diformat
                $date = \Carbon\Carbon::parse($meeting->date);
                $key = $participant->id . '_ மட்டு்ர _' . $date->format('Y-m-d');
                
                // Buat objek AttendanceSummary sementara untuk meeting
                $meetingSummary = new AttendanceSummary([
                    'user_id' => $participant->id,
                    'date' => $meeting->date,
                    'is_leave' => true,
                    'leave_type' => 'Meeting Keluar Kota',
                    'notes' => (\App\Models\AttendanceSummary::where('user_id', $participant->id)->whereDate('date', $meeting->date)->where('leave_type', 'Meeting Keluar Kota')->exists() ? \App\Models\AttendanceSummary::where('user_id', $participant->id)->whereDate('date', $meeting->date)->where('leave_type', 'Meeting Keluar Kota')->first()->notes . '; ' : '') .'Meeting keluar kota: ' . $meeting->title,
                    'status' => $meeting->status,
                    'check_in' => null, 
                    'check_out' => null,
                    'is_late' => false,
                    'is_early_leave' => false,
                    'is_absent' => false,
                ]);

                // Pastikan date adalah objek Carbon
                $meetingSummary->date = \Carbon\Carbon::parse($meetingSummary->date);

                $meetingSummary->user = $participant; // Assign user relationship for view
                
                // Timpa entri yang ada di koleksi final dengan data meeting
                // Ini akan memastikan data meeting menimpa data absensi reguler jika ada
                $finalSummaries->put($key, $meetingSummary);
            }
        }

        // Konversi kembali ke daftar dan urutkan
        $summaries = $finalSummaries->values()->sortByDesc('date');

        return view('backoffice.attendance.summary.index', compact('summaries', 'users'));
    }

    public function create()
    {
        $users = User::all();
        return view('backoffice.attendance.summary.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'is_late' => 'boolean',
            'is_early_leave' => 'boolean',
            'is_absent' => 'boolean',
            'is_leave' => 'boolean',
            'leave_type' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        AttendanceSummary::create($validated);

        return redirect()->route('attendance.summary.index')
            ->with('success', 'Rekapitulasi absensi berhasil ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        try {
            $summary = AttendanceSummary::findOrFail($id);
            $users = User::all();
            return view('backoffice.attendance.summary.edit', compact('summary', 'users'));
        } catch (\Exception $e) {
            return redirect()->route('attendance.summary.index')
                ->with('error', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $summary = AttendanceSummary::findOrFail($id);
            
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'is_late' => 'boolean',
                'is_early_leave' => 'boolean',
                'is_absent' => 'boolean',
                'is_leave' => 'boolean',
                'leave_type' => 'nullable|string|max:255',
                'notes' => 'nullable|string'
            ]);

            $summary->update($validated);

            return redirect()->route('attendance.summary.index')
                ->with('success', 'Rekapitulasi absensi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('attendance.summary.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $summary = AttendanceSummary::findOrFail($id);
            
            // Hapus data
            $summary->delete();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Data rekapitulasi absensi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function report(Request $request)
    {
        $query = AttendanceSummary::with('user')
            ->when($request->filled('start_date'), function ($q) use ($request) {
                return $q->whereDate('date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                return $q->whereDate('date', '<=', $request->end_date);
            })
            ->when($request->filled('user_id'), function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            });

        $summaries = $query->get();
        $users = User::all();

        // Tambahkan data meeting keluar kota
        $meetings = \App\Models\Meet::with(['participants'])
            ->where('category', 'out_of_town')
            ->where('status', '!=', 'cancelled')
            ->when($request->filled('start_date'), function ($q) use ($request) {
                return $q->whereDate('date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                return $q->whereDate('date', '<=', $request->end_date);
            })
            ->when($request->filled('user_id'), function ($q) use ($request) {
                return $q->whereHas('participants', function($query) use ($request) {
                    $query->where('user_id', $request->user_id);
                });
            })
            ->get();

        // Gabungkan data meeting ke summaries
        foreach ($meetings as $meeting) {
            foreach ($meeting->participants as $participant) {
                $summary = new AttendanceSummary([
                    'user_id' => $participant->id,
                    'date' => $meeting->date,
                    'is_leave' => true,
                    'leave_type' => 'Meeting Keluar Kota',
                    'notes' => 'Meeting keluar kota: ' . $meeting->title,
                    'status' => 'approved'
                ]);
                $summary->user = $participant;
                $summaries->push($summary);
            }
        }

        $report = $summaries->groupBy('user_id')->map(function ($items) {
            return [
                'user' => $items->first()->user,
                'total_days' => $items->count(),
                'total_late' => $items->where('is_late', true)->count(),
                'total_early_leave' => $items->where('is_early_leave', true)->count(),
                'total_absent' => $items->where('is_absent', true)->count(),
                'total_leave' => $items->where('is_leave', true)->count(),
                'total_meeting' => $items->where('leave_type', 'Meeting Keluar Kota')->count(),
            ];
        });

        return view('backoffice.attendance.summary.report', compact('report', 'users'));
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            
            $summary = AttendanceSummary::findOrFail($id);
            
            // Hapus data
            $summary->delete();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Data rekapitulasi absensi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
} 