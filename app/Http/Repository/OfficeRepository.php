<?php

namespace App\Http\Repository;

use App\Models\Office;

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
}