<?php

namespace App\Http\Repository;

use App\Models\Office;
use Illuminate\Support\Facades\Storage;

class OfficeRepository
{
    public function getAll()
    {
        try {
            return Office::orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Office::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $office = new Office();
            $office->name = $data->name;
            $office->address = $data->address;
            $office->latitude = $data->latitude;
            $office->longitude = $data->longitude;
            $office->radius = $data->radius;
            if ($data->file('image')) {
                $file = $data->file('image');
                $path = Storage::disk('public')->put('office', $file);
                $office->image = $path;
            }
            $office->save();

            return $office;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id, $data)
    {
        try {
            $office = Office::find($id);
            $office->name = $data->name;
            $office->address = $data->address;
            $office->latitude = $data->latitude;
            $office->longitude = $data->longitude;
            $office->radius = $data->radius;
            if ($data->file('image')) {
                if ($office->image) {
                    Storage::disk('public')->delete($office->image);
                }
                $file = $data->file('image');
                $path = Storage::disk('public')->put('office', $file);
                $office->image = $path;
            }
            $office->save();

            return $office;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $office = Office::find($id);
            if ($office->image) {
                Storage::disk('public')->delete($office->image);
            }
            $office->delete();
            return $office;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}