<?php

namespace App\Http\Repository;

use App\Models\Division;

class DivisionRepository
{
    public function getAll()
    {
        try {
            return Division::orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Division::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($request)
    {
        try {
            $division = new Division();
            $division->name = $request->name;
            $division->save();
            return $division;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($request, $id)
    {
        try {
            $division = Division::find($id);
            $division->name = $request->name;
            $division->save();
            return $division;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $division = Division::find($id);
            $division->delete();
            return $division;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}