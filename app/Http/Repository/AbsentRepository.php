<?php

namespace App\Http\Repository;

use App\Models\Absent;
use Illuminate\Support\Facades\Auth;

class AbsentRepository
{
    public function getAll()
    {
        try {
            return Absent::orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getByAuth()
    {
        try {
            return Absent::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAbsenToday()
    {
        try {
            return Absent::whereDate('created_at', now()->format('Y-m-d'))->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAbsenTodayByUserId()
    {
        try {
            return Absent::where('user_id', Auth::user()->id)->whereDate('created_at', now()->format('Y-m-d'))->first();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Absent::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeStart($data)
    {
        try {
            $absent = new Absent();
            $absent->user_id = Auth::user()->id;
            $absent->shift_id = $data->shift_id;
            $absent->office_id = 1;
            $absent->start = $data->start;
            $absent->end = $data->end;
            $absent->longitude = "-6.25669089852724";
            $absent->latitude = "106.79641151260287";
            $absent->status = "Absen";
            $absent->save();

            return $absent;
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