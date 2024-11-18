<?php

namespace App\Http\Repository;

use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class SubmissionRepository
{
    public function getAllByTypeCuti()
    {
        try {
            return Submission::orderBy('id', 'desc')->where('type', 'cuti')->get();
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

    public function storeCuti($data)
    {
        try {
            $submission = new Submission();
            $submission->user_id = Auth::user()->id;
            $submission->start_date = $data['start_date'];
            $submission->end_date = $data['end_date'];
            $start = new \DateTime($submission->start_date);
            $end = new \DateTime($submission->end_date);
            $interval = $start->diff($end);
            $days = $interval->format('%a');
            $total_hari = $days + 1;
            $submission->total_day = $total_hari;
            $submission->type = "Cuti";
            $submission->description = $data['description'];
            $submission->status = "Pengajuan";
            $submission->save();

            return $submission;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function confirm($id)
    {
        try {
            $submission = Submission::find($id);
            $submission->status = "Disetujui";
            $submission->save();
            return $submission;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function reject($id)
    {
        try {
            $submission = Submission::find($id);
            $submission->status = "Ditolak";
            $submission->save();
            return $submission;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllNonTypeCuti()
    {
        try {
            if (Auth::user()->role_id == 1) {
                return Submission::orderBy('id', 'desc')->where('type', '!=', 'cuti')->get();
            } else {
                return Submission::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->where('type', '!=', 'cuti')->get();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeNonTypeCuti($data)
    {
        try {
            $submission = new Submission();
            $submission->user_id = Auth::user()->id;
            $submission->start_date = $data['start_date'];
            $submission->end_date = $data['end_date'];
            $start = new \DateTime($submission->start_date);
            $end = new \DateTime($submission->end_date);
            $interval = $start->diff($end);
            $days = $interval->format('%a');
            $total_hari = $days + 1;
            $submission->total_day = $total_hari;
            $submission->type = $data['type'];
            $submission->description = $data['description'];
            $submission->status = "Pengajuan";
            $submission->save();

            return $submission;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id, $data)
    {
        try {
            $submission = Submission::find($id);
            $submission->start_date = $data['start_date'];
            $submission->end_date = $data['end_date'];
            $start = new \DateTime($submission->start_date);
            $end = new \DateTime($submission->end_date);
            $interval = $start->diff($end);
            $days = $interval->format('%a');
            $total_hari = $days + 1;
            $submission->total_day = $total_hari;
            $submission->type = $data['type'];
            $submission->description = $data['description'];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $submission = Submission::find($id);
            $submission->delete();
            return $submission;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}