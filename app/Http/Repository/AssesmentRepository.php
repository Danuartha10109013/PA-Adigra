<?php

namespace App\Http\Repository;

use App\Models\Assesment;

class AssesmentRepository
{
    public function getAll()
    {
        try {
            return Assesment::orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}