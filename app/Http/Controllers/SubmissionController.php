<?php

namespace App\Http\Controllers;

use App\Http\Repository\SubmissionRepository;
use Illuminate\Http\Request;
use App\Models\LeaveQuota;
use Illuminate\Support\Facades\Auth;
use App\Mail\LeaveSubmissionMail;
use App\Mail\SickLeaveSubmissionMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveApprovalMail;
use App\Mail\LeaveRejectionMail;
use App\Mail\SickLeaveApprovalMail;
use App\Mail\SickLeaveRejectionMail;

class SubmissionController extends Controller
{
    private $submissionRepository;

    public function __construct(SubmissionRepository $submissionRepository)
    {
        $this->submissionRepository = $submissionRepository;
    }

    // cuti
    public function cuti(Request $request)
    {
        $submissions = $this->submissionRepository->getAllByTypeCuti($request);
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $hadir = null;
        $sakit = null;
        $izin = null;
        $cuti = null;

        if ($bulan && $tahun) {
            $sakit = $submissions->where('type', 'sakit')->count();
            $izin = $submissions->where('type', 'izin')->count();
            $cuti = $submissions->where('type', 'cuti')->count();
        }
        return view('backoffice.submission.cuti.index', compact(['submissions', 'bulan', 'tahun', 'hadir', 'sakit', 'izin', 'cuti']));
    }

    public function storeCuti(Request $request)
    {
        // Validasi jatah cuti tahunan
        $year = date('Y', strtotime($request->start_date));
        $userQuota = \App\Models\LeaveQuota::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'year' => $year,
            ],
            [
                'quota' => 30,
                'used' => 0,
            ]
        );

        // Hitung total hari cuti yang diajukan
        $start = new \DateTime($request->start_date);
        $end = new \DateTime($request->end_date);
        $interval = $start->diff($end);
        $totalDays = $interval->format('%a') + 1;

        // Cek apakah masih ada jatah cuti tersisa
        if (($userQuota->used + $totalDays) > $userQuota->quota) {
            $sisaCuti = $userQuota->quota - $userQuota->used;
            return redirect('/backoffice/submission/cuti')
                ->with('error', "Jatah cuti tahunan tidak mencukupi. Sisa jatah cuti: {$sisaCuti} hari, yang diajukan: {$totalDays} hari");
        }

        $submission = $this->submissionRepository->storeCuti($request);
        // Kirim email ke admin jika pengaju adalah karyawan
        if (Auth::user()->role_id == 2) {
            $admins = User::where('role_id', 1)->get();
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new LeaveSubmissionMail($submission, Auth::user()));
            }
        }
        return redirect('/backoffice/submission/cuti')->with('success', 'Cuti telah ditambahkan');
    }

    public function updateCuti(Request $request, $id)
    {
        $submission = $this->submissionRepository->update($request, $id);
        return redirect('/backoffice/submission/cuti')->with('success', 'Cuti telah diubah');
    }

    public function deleteCuti($id)
    {
        $submission = $this->submissionRepository->delete($id);
        return redirect('/backoffice/submission/cuti')->with('success', 'Cuti telah dihapus');
    }

    public function confirmCuti($id)
    {
        $submission = $this->submissionRepository->confirm($id);
        // Kirim email persetujuan ke pengaju
        $user = \App\Models\User::find($submission->user_id);
        if ($user) {
            Mail::to($user->email)->send(new LeaveApprovalMail($submission, Auth::user()));
        }
        return redirect('/backoffice/submission/cuti')->with('success', 'Cuti telah disetujui');
    }

    public function rejectCuti(Request $request, $id)
    {
        $submission = $this->submissionRepository->reject($request, $id);
        // Kirim email penolakan ke pengaju
        $user = \App\Models\User::find($submission->user_id);
        if ($user) {
            Mail::to($user->email)->send(new LeaveRejectionMail($submission, Auth::user()));
        }
        return redirect('/backoffice/submission/cuti')->with('success', 'Cuti telah ditolak');
    }

    public function adjustCuti(Request $request, $id)
    {
        $submission = $this->submissionRepository->update($request, $id);
        return redirect('/backoffice/submission/cuti')->with('success', 'Pengajuan cuti telah disesuaikan');
    }

    public function updateStatusDescriptionCuti(Request $request, $id)
    {
        $submission = $this->submissionRepository->reject($request, $id);
        return redirect('/backoffice/submission/cuti')->with('success', 'Keterangan ditolak telah diubah');
    }

    // izin-sakit
    public function izinSakit(Request $request)
    {
        $submissions = $this->submissionRepository->getAllNonTypeCuti($request);
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $hadir = null;
        $sakit = null;
        $izin = null;
        $cuti = null;

        if ($bulan && $tahun) {
            $sakit = $submissions->where('type', 'sakit')->count();
            $izin = $submissions->where('type', 'izin')->count();
            $cuti = $submissions->where('type', 'cuti')->count();
        }

        return view('backoffice.submission.izin-sakit.index', compact(['submissions', 'bulan', 'tahun', 'hadir', 'sakit', 'izin', 'cuti'])); 
    }

    public function storeIzinSakit(Request $request)
    {
        $submission = $this->submissionRepository->storeNonTypeCuti($request);
        // Kirim email ke admin jika pengaju adalah karyawan
        if (Auth::user()->role_id == 2) {
            $admins = User::where('role_id', 1)->get();
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new SickLeaveSubmissionMail($submission, Auth::user()));
            }
        }
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Pengajuan telah ditambahkan');
    }

    public function updateIzinSakit(Request $request, $id)
    {
        // dd($request->all());
        $submission = $this->submissionRepository->update($request, $id);
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Pengajuan telah diubah');
    }

    public function deleteIzinSakit($id)
    {
        $submission = $this->submissionRepository->delete($id);
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Pengajuan telah dihapus');
    }

    public function confirmIzinSakit($id)
    {
        $submission = $this->submissionRepository->confirm($id);
        // Kirim email persetujuan ke pengaju
        $user = \App\Models\User::find($submission->user_id);
        if ($user) {
            Mail::to($user->email)->send(new SickLeaveApprovalMail($submission, Auth::user()));
        }
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Pengajuan telah disetujui');
    }

    public function rejectIzinSakit(Request $request, $id)
    {
        $submission = $this->submissionRepository->reject($request, $id);
        // Kirim email penolakan ke pengaju
        $user = \App\Models\User::find($submission->user_id);
        if ($user) {
            Mail::to($user->email)->send(new SickLeaveRejectionMail($submission, Auth::user()));
        }
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Pengajuan telah ditolak');
    }

    public function adjustIzinSakit(Request $request, $id)
    {
        $submission = $this->submissionRepository->update($request, $id);
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Pengajuan telah disesuaikan');
    }

    public function updateStatusDescriptionIzinSakit(Request $request, $id)
    {
        $submission = $this->submissionRepository->reject($request, $id);
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Keterangan ditolak telah diubah');
    }
}
