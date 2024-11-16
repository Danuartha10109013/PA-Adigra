<?php

namespace App\Http\Repository;

use App\Models\Shift;

class ShiftRepository
{
    public function getAll()
    {
        try {
            return Shift::orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Shift::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($request)
    {
        try {
            $shift = new Shift();
            $shift->name = $request->name;
            $shift->start = $request->start;
            $shift->end = $request->end;
            $shift->save();
            return $shift;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($request, $id)
    {
        try {
            $shift = Shift::find($id);
            $shift->name = $request->name;
            $shift->start = $request->start;
            $shift->end = $request->end;
            $shift->save();
            return $shift;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $shift = Shift::find($id);
            $shift->delete();
            return $shift;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}