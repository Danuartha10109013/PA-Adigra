<?php

namespace App\Http\Controllers;

use App\Http\Repository\SubmissionRepository;
use Illuminate\Http\Request;

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
        $submission = $this->submissionRepository->storeCuti($request);
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
        return redirect('/backoffice/submission/cuti')->with('success', 'Cuti telah disetujui');
    }

    public function rejectCuti(Request $request, $id)
    {
        $submission = $this->submissionRepository->reject($request, $id);
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
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Pengajuan telah disetujui');
    }

    public function rejectIzinSakit(Request $request, $id)
    {
        $submission = $this->submissionRepository->reject($request, $id);
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
