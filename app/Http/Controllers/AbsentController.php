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

    public function index()
    {
        // $divisions = $this->divisionRepository->getAll();
        return view('backoffice.absent-data.absent.index');
    }

    // modul karyawan
    public function create()
    {
        $shifts = $this->shiftRepository->getAll();
        $user = $this->userRepository->getByAuth();
        $absentToday = $this->absentRepository->getAbsenTodayByUserId();
        return view('backoffice.karyawan.absent.create', compact('shifts', 'user', 'absentToday'));
    }

    public function self()
    {
        $absents = $this->absentRepository->getByAuth();
        return view('backoffice.karyawan.absent.self', compact('absents'));
    }

    public function store(Request $request)
    {
        $absentToday = Absent::where('user_id', Auth::user()->id)->whereDate('created_at', now()->format('Y-m-d'))->first();

        if ($absentToday) {
            if ($absentToday->end == null) {
                $absentToday->end = now();
                $absentToday->save();
                return redirect('/backoffice/absen/create')->with('success', 'Absen pulang');
            } else {
                return redirect('/backoffice/absen/create')->with('error', 'Anda sudah absen pulang');
            }
        }

        $absent = new Absent();
        $absent->user_id = Auth::user()->id;
        $absent->shift_id = $request->shift_id;
        $absent->office_id = 1;
        $absent->start = now();
        $absent->longitude = "-6.25669089852724";
        $absent->latitude = "106.79641151260287";
        $absent->status = "Absen";
        $absent->save();
        return redirect('/backoffice/absen/create')->with('success', 'Absen masuk');
    }

    public function detail($id)
    {
        $absent = $this->absentRepository->getById($id);
        return view('backoffice.karyawan.absent.detail', compact('absent'));
    }
    // end modul karyawan
}
