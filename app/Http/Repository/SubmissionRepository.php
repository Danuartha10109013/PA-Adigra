<?php

namespace App\Http\Repository;

use App\Models\Submission;

class SubmissionRepository
{
    public function getAll()
    {
        try {
            return Submission::orderBy('id', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Submission::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            
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