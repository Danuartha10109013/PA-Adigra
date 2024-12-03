<?php

namespace App\Http\Repository;

use App\Models\Absent;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class SubmissionRepository
{
    public function getAllByTypeCuti($data)
    {
        try {

            $submissions = Submission::where('type', 'cuti')->orderBy('updated_at', 'desc');

            $bulan = $data->bulan;
            $tahun = $data->tahun;

            if ($bulan && $tahun) {
                $submissions->whereMonth('updated_at', $bulan)->whereYear('updated_at', $tahun);
            }

            if (Auth::user()->role_id == 1) {
                return $submissions->get();
            } else {
                return $submissions->where('user_id', Auth::user()->id)->get();
            }
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
            $submission->type = "cuti";
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

            // insert to absent foreach
            $start = new \DateTime($submission->start_date);
            $end = new \DateTime($submission->end_date);

            if ($start == $end) {
                $absent = new Absent();
                $absent->user_id = $submission->user_id;
                $absent->office_id = $submission->user->office_id;
                $absent->status = $submission->type;
                $absent->date = $start->format('Y-m-d');
                $absent->description = $submission->description;
                $absent->save();
            } else {
                $interval = $start->diff($end);
                $days = $interval->format('%a');
                $total_hari = $days + 1;
                for ($i = 0; $i < $total_hari; $i++) {
                    $absent = new Absent();
                    $absent->user_id = $submission->user_id;
                    $absent->office_id = $submission->user->office_id;
                    $absent->status = $submission->type;
                    $absent->date = $start->format('Y-m-d');
                    $absent->description = $submission->description;
                    $absent->save();
                    $start->modify('+1 day');
                }
            }

            return $submission;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function reject($data, $id)
    {
        try {
            $submission = Submission::find($id);
            $submission->status = "Ditolak";
            $submission->status_description = $data['status_description'];
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
                return Submission::orderBy('updated_at', 'desc')->where('type', '!=', 'cuti')->get();
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

    public function update($data, $id)
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
            $submission->status = "Pengajuan";
            $submission->save();

            return $submission;
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