<?php

namespace App\Http\Repository;

use App\Models\Absent;
use Illuminate\Support\Facades\Auth;

class AbsentRepository
{
    public function getAll($data)
    {
        try {

            $absents = Absent::orderBy('id', 'desc');

            $bulan = $data->bulan;
            $tahun = $data->tahun;

            if ($bulan && $tahun) {
                $absents->whereMonth('date', $bulan)->whereYear('date', $tahun);
            }

            return $absents->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getByAuth($data)
    {
        try {

            $absents = Absent::where('user_id', Auth::user()->id)->orderBy('id', 'desc');

            $bulan = $data->bulan;
            $tahun = $data->tahun;

            if ($bulan && $tahun) {
                $absents->whereMonth('date', $bulan)->whereYear('date', $tahun);
            }

            return $absents->get();

            // return Absent::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    

    public function getAbsenToday()
    {
        try {
            return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'Absen')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function countAbsenToday()
    {
        try {
            return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'Absen')->count();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCutiToday()
    {
        try {
            return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'cuti')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function countCutiToday()
    {
        try {
            return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'cuti')->count();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // public function getIzinSakitToday()
    // {
    //     try {
    //         return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'izin')->where('status', 'sakit')->get();
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    // public function countIzinSakitToday()
    // {
    //     try {
    //         return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'izin')->Where('status', 'sakit')->count();
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    public function getIzinToday() 
    {
        try {
            return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'izin')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function countIzinToday() 
    {
        try {
            return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'izin')->count();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getSakitToday()
    {
        try {
            return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'sakit')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function countSakitToday()
    {
        try {
            return Absent::whereDate('date', now()->format('Y-m-d'))->where('status', 'sakit')->count();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAbsenTodayByUserId()
    {
        try {
            return Absent::where('user_id', Auth::user()->id)
                ->whereDate('date', now()->format('Y-m-d'))
                ->where(function($query) {
                    $query->where('description', 'not like', 'Meeting keluar kota: %')
                          ->orWhereNull('description');
                })
                ->where(function($query) {
                    $query->where('status', '!=', 'completed')
                          ->orWhereNull('status');
                })
                ->first();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Absent::with(['office', 'user'])->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id, $data)
    {
        try {
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}