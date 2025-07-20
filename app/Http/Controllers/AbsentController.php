<?php

namespace App\Http\Controllers;

use App\Http\Repository\AbsentRepository;
use App\Http\Repository\UserRepository;
use App\Models\Absent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsentController extends Controller
{
    private $absentRepository;
    private $userRepository;

    public function __construct(AbsentRepository $absentRepository, UserRepository $userRepository)
    {
        $this->absentRepository = $absentRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $absents = $this->absentRepository->getAll($request);
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $hadir = null;
        $sakit = null;
        $izin = null;
        $cuti = null;

        if ($bulan && $tahun) {
            $hadir = $absents->where('status', 'Absen')->count();
            $sakit = $absents->where('status', 'sakit')->count();
            $izin = $absents->where('status', 'izin')->count();
            $cuti = $absents->where('status', 'cuti')->count();
        }

        return view('backoffice.absent.index', compact(['absents', 'bulan', 'tahun', 'hadir', 'sakit', 'izin', 'cuti']));
    }

    // modul karyawan
    public function create()
    {
        $user = $this->userRepository->getByAuth();
        $absentToday = $this->absentRepository->getAbsenTodayByUserId();
        
        // Cek apakah user sedang dalam meeting keluar kota
        $meetingOutOfTown = \App\Models\Meet::whereHas('participants', function($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->where('category', 'out_of_town')
            ->whereDate('date', now()->format('Y-m-d'))
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->first();
        
        // Jika sedang meeting keluar kota, buat dummy absentToday
        if ($meetingOutOfTown && !$absentToday) {
            $absentToday = (object) [
                'status' => 'Meeting Keluar Kota',
                'start' => null,
                'end' => null
            ];
        }
        
        return view('backoffice.karyawan.absent.index', compact('user', 'absentToday'));
    }

    public function self(Request $request)
    {
        $absents = $this->absentRepository->getByAuth($request);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $hadir = null;
        $sakit = null;
        $izin = null;
        $cuti = null;

        if ($bulan && $tahun) {
            $hadir = $absents->where('status', 'Absen')->count();
            $sakit = $absents->where('status', 'sakit')->count();
            $izin = $absents->where('status', 'izin')->count();
            $cuti = $absents->where('status', 'cuti')->count();
        }

        return view('backoffice.karyawan.absent.self', compact(['absents', 'bulan', 'tahun', 'hadir', 'sakit', 'izin', 'cuti']));
    }

    public function store(Request $request)
    {
        $jenisAbsen = $request->jenis_absen;
        $user = $this->userRepository->getByAuth();

        if ($jenisAbsen === 'WFH') {
            // Cek apakah sudah absen masuk hari ini
            $existingAbsent = Absent::where('user_id', Auth::user()->id)
                ->whereDate('date', now()->format('Y-m-d'))
                ->where('status', 'WFH')
                ->first();

            // Jika sudah absen masuk, cek absen pulang
            if ($existingAbsent && $existingAbsent->start && !$existingAbsent->end) {
                $startTime = Carbon::parse($existingAbsent->start);
                $currentTime = Carbon::now();
                $workMinutes = $currentTime->diffInMinutes($startTime);
                $requiredMinutes = $user->minimum_work_hours * 60;
                if ($workMinutes < $requiredMinutes) {
                    $remainingMinutes = $requiredMinutes - $workMinutes;
                    $remainingHours = floor($remainingMinutes / 60);
                    $remainingMins = $remainingMinutes % 60;
                    $remainingText = $remainingHours > 0 ? "{$remainingHours} jam {$remainingMins} menit" : "{$remainingMins} menit";
                    return redirect('/backoffice/absen/create')
                        ->with('error', "⏰ Anda belum bisa pulang. Masih perlu bekerja {$remainingText} lagi untuk memenuhi jam kerja minimal.");
                } else {
                    $existingAbsent->end = now();
                    $existingAbsent->save();
                    return redirect('/backoffice/absen/create')->with('success', '✅ Absen pulang WFH berhasil! Anda sudah memenuhi jam kerja minimal.');
                }
            }
            // Jika belum absen masuk, proses absen masuk WFH
            if (!$existingAbsent) {
                // Simpan foto base64 ke file
                $buktiFotoBase64 = $request->bukti_foto;
                $buktiFotoPath = null;
                if ($buktiFotoBase64) {
                    $fotoData = base64_decode(preg_replace('#^data:image/\\w+;base64,#i', '', $buktiFotoBase64));
                    $fileName = 'wfh_' . Auth::user()->id . '_' . date('Ymd_His') . '.png';
                    $filePath = 'absensi/wfh/' . $fileName;
                    Storage::disk('public')->put($filePath, $fotoData);
                    $buktiFotoPath = $filePath;
                }
                $absent = new Absent();
                $absent->user_id = Auth::user()->id;
                $absent->office_id = Auth::user()->office_id;
                $absent->start = now();
                $absent->latitude = $request->latitude;
                $absent->longitude = $request->longitude;
                $absent->status = "wfh";
                $absent->date = now()->format('Y-m-d');
                $absent->bukti_foto = $buktiFotoPath;
                $absent->save();
                return redirect('/backoffice/absen/create')->with('success', '✅ Absen masuk WFH berhasil! Silakan bekerja minimal ' . $user->minimum_work_hours . ' jam.');
            }
            // fallback
            return redirect('/backoffice/absen/create')->with('error', 'Terjadi kesalahan absen WFH.');
        }

        // --- LOGIKA LAMA UNTUK WFO ---
        $absentToday = Absent::where('user_id', Auth::user()->id)
            ->whereDate('date', now()->format('Y-m-d'))
            ->where(function($query) {
                $query->where('description', 'not like', 'Meeting keluar kota: %')
                      ->orWhereNull('description');
            })
            ->first();

        // Cek apakah user sedang meeting keluar kota yang belum selesai atau dibatalkan
        $meetingOutOfTown = \App\Models\Meet::whereHas('participants', function($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->where('category', 'out_of_town')
            ->whereDate('date', now()->format('Y-m-d'))
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->first();

        if ($meetingOutOfTown) {
            return redirect('/backoffice/absen/create')
                ->with('error', '🚫 Anda sedang dalam meeting keluar kota yang belum selesai atau dibatalkan: ' . $meetingOutOfTown->title);
        }

        // Cek apakah ada record absensi meeting yang sudah selesai, jika ada hapus
        $completedMeetingAbsent = Absent::where('user_id', Auth::user()->id)
            ->whereDate('date', now()->format('Y-m-d'))
            ->where('description', 'like', 'Meeting keluar kota: %')
            ->where('status', 'completed')
            ->first();

        if ($completedMeetingAbsent) {
            $completedMeetingAbsent->delete();
        }

        $earthRadius = 6371;
        $longitudeUser = $request->longitude;
        $latitudeUser = $request->latitude;

        $longitudeOffice = $user->office->longitude;
        $latitudeOffice = $user->office->latitude;
        $radiusOffice = $user->office->radius / 1000; // Convert meter to km

        // Debug logging
        Log::info('Absen Debug Info', [
            'user_coords' => [$latitudeUser, $longitudeUser],
            'office_coords' => [$latitudeOffice, $longitudeOffice],
            'office_radius_meter' => $user->office->radius,
            'office_radius_km' => $radiusOffice,
            'user_id' => Auth::user()->id,
            'office_id' => $user->office_id
        ]);

        // Menghitung perbedaan koordinat
        $latFrom = deg2rad($latitudeUser);
        $lonFrom = deg2rad($longitudeUser);
        $latTo = deg2rad($latitudeOffice);
        $lonTo = deg2rad($longitudeOffice);

        // Menghitung perbedaan latitude dan longitude
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        // Menggunakan rumus Haversine
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Menghitung jarak
        $distance = $earthRadius * $c;

        // Debug logging jarak
        Log::info('Distance calculation', [
            'calculated_distance_km' => $distance,
            'office_radius_km' => $radiusOffice,
            'is_within_radius' => $distance <= $radiusOffice
        ]);

        // Validasi radius
        if ($distance > $radiusOffice) {
            return redirect('/backoffice/absen/create')
                ->with('error', "📍 Anda tidak berada di radius lokasi kerja. Jarak: " . round($distance * 1000, 0) . " meter, Radius kantor: " . $user->office->radius . " meter");
        }

        // Cek apakah ada record absensi normal yang sudah ada
        $existingAbsent = Absent::where('user_id', Auth::user()->id)
            ->whereDate('date', now()->format('Y-m-d'))
            ->where('status', 'Absen')
            ->first();

        // Jika sudah ada absen masuk, cek apakah bisa pulang
        if ($existingAbsent && $existingAbsent->start && !$existingAbsent->end) {
            // Cek apakah sudah memenuhi jam kerja minimal
            $startTime = Carbon::parse($existingAbsent->start);
            $currentTime = Carbon::now();
            $workMinutes = $currentTime->diffInMinutes($startTime);
            $requiredMinutes = $user->minimum_work_hours * 60;
            
            if ($workMinutes < $requiredMinutes) {
                $remainingMinutes = $requiredMinutes - $workMinutes;
                $remainingHours = floor($remainingMinutes / 60);
                $remainingMins = $remainingMinutes % 60;
                
                if ($remainingHours > 0) {
                    $remainingText = "{$remainingHours} jam {$remainingMins} menit";
                } else {
                    $remainingText = "{$remainingMins} menit";
                }
                
                return redirect('/backoffice/absen/create')
                    ->with('error', "⏰ Anda belum bisa pulang. Masih perlu bekerja {$remainingText} lagi untuk memenuhi jam kerja minimal.");
            } else {
                $existingAbsent->end = now();
                $existingAbsent->save();
                return redirect('/backoffice/absen/create')->with('success', '✅ Absen pulang berhasil! Anda sudah memenuhi jam kerja minimal.');
            }
        }

        // Jika belum ada absen masuk, buat absen masuk baru
        if (!$existingAbsent) {
            $absent = new Absent();
            $absent->user_id = Auth::user()->id;
            $absent->office_id = Auth::user()->office_id;
            $absent->start = now();
            $absent->latitude = $latitudeUser;
            $absent->longitude = $longitudeUser;
            $absent->status = "Absen";
            $absent->date = now()->format('Y-m-d');
            $absent->save();
            return redirect('/backoffice/absen/create')->with('success', '✅ Absen masuk berhasil! Silakan bekerja minimal ' . $user->minimum_work_hours . ' jam.');
        }
    }

    public function detail($id)
    {
        $absent = $this->absentRepository->getById($id);
        return view('backoffice.karyawan.absent.detail', compact('absent'));
    }
    // end modul karyawan
}
