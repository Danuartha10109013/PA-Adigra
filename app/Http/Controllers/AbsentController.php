<?php

namespace App\Http\Controllers;

use App\Http\Repository\AbsentRepository;
use App\Http\Repository\ShiftRepository;
use App\Http\Repository\UserRepository;
use App\Models\Absent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsentController extends Controller
{
    private $absentRepository;
    private $shiftRepository;
    private $userRepository;

    public function __construct(AbsentRepository $absentRepository, ShiftRepository $shiftRepository, UserRepository $userRepository)
    {
        $this->absentRepository = $absentRepository;
        $this->shiftRepository = $shiftRepository;
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

        return view('backoffice..absent.index', compact(['absents', 'bulan', 'tahun', 'hadir', 'sakit', 'izin', 'cuti']));
    }

    // modul karyawan
    public function create()
    {
        $shifts = $this->shiftRepository->getAll();
        $user = $this->userRepository->getByAuth();
        $absentToday = $this->absentRepository->getAbsenTodayByUserId();
        return view('backoffice.karyawan.absent.index', compact('shifts', 'user', 'absentToday'));
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
        $absentToday = Absent::where('user_id', Auth::user()->id)->whereDate('created_at', now()->format('Y-m-d'))->first();

        $user = $this->userRepository->getByAuth();

        $earthRadius = 6371;

        // $longitudeUser = -6.25669089852724;
        // $latitudeUser = 106.79641151260287;
        $longitudeUser = $request->longitude;
        $latitudeUser = $request->latitude;

        // dd($longitudeUser, $latitudeUser);

        $longitudeOffice = $user->office->longitude;
        $latitudeOffice = $user->office->latitude;
        $radiusOffice = $user->office->radius / 1000;

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

        // radius
        if ($distance <= $radiusOffice) {
            dd('absen');
            if ($absentToday) {
                if ($absentToday->end == null) {
                    if (now()->format('H:i:s') < $absentToday->shift->end) {
                        return redirect('/backoffice/absen/create')->with('error', 'Anda belum waktunya pulang');
                    } else {
                        $absentToday->end = now();
                        $absentToday->save();
                        return redirect('/backoffice/absen/create')->with('success', 'Absen pulang');
                    }
                } else {
                    return redirect('/backoffice/absen/create')->with('error', 'Anda sudah absen pulang');
                }
            }
    
            $absent = new Absent();
            $absent->user_id = Auth::user()->id;
            $absent->shift_id = $request->shift_id;
            $absent->office_id = Auth::user()->office_id;
            $absent->start = now();
            $absent->longitude = "-6.25669089852724";
            $absent->latitude = "106.79641151260287";
            $absent->status = "Absen";
            $absent->date = now()->format('Y-m-d');
            $absent->save();
            return redirect('/backoffice/absen/create')->with('success', 'Absen masuk');
        }   else {
            dd('tidak absen');
            return redirect('/backoffice/absen/create')->with('error', 'Anda tidak berada di radius lokasi kerja');
        }

        // if ($absentToday) {
        //     if ($absentToday->end == null) {
        //         if (now()->format('H:i:s') < $absentToday->shift->end) {
        //             return redirect('/backoffice/absen/create')->with('error', 'Anda belum waktunya pulang');
        //         } else {
        //             $absentToday->end = now();
        //             $absentToday->save();
        //             return redirect('/backoffice/absen/create')->with('success', 'Absen pulang');
        //         }
        //     } else {
        //         return redirect('/backoffice/absen/create')->with('error', 'Anda sudah absen pulang');
        //     }
        // }

        // $absent = new Absent();
        // $absent->user_id = Auth::user()->id;
        // $absent->shift_id = $request->shift_id;
        // $absent->office_id = Auth::user()->office_id;
        // $absent->start = now();
        // $absent->longitude = "-6.25669089852724";
        // $absent->latitude = "106.79641151260287";
        // $absent->status = "Absen";
        // $absent->date = now()->format('Y-m-d');
        // $absent->save();
        // return redirect('/backoffice/absen/create')->with('success', 'Absen masuk');
    }

    public function detail($id)
    {
        $absent = $this->absentRepository->getById($id);
        return view('backoffice.karyawan.absent.detail', compact('absent'));
    }
    // end modul karyawan
}
