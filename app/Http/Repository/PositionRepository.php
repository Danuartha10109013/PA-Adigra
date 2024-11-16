<?php

namespace App\Http\Repository;

use App\Models\Position;

class PositionRepository
{
    public function getAll()
    {
        try {
            return Position::orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Position::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($request)
    {
        try {
            $position = new Position();
            $position->name = $request->name;
            $position->save();
            return $position;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($request, $id)
    {
        try {
            $position = Position::find($id);
            $position->name = $request->name;
            $position->save();
            return $position;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $position = Position::find($id);
            $position->delete();
            return $position;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}