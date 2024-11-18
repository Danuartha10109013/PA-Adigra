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
    public function cuti()
    {
        $submissions = $this->submissionRepository->getAllByTypeCuti();
        return view('backoffice.submission.cuti.index', compact('submissions'));
    }

    public function storeCuti(Request $request)
    {
        $submission = $this->submissionRepository->storeCuti($request);
        return redirect('/backoffice/submission/cuti')->with('success', 'Cuti telah ditambahkan');
    }

    public function updateCuti(Request $request, $id)
    {
        $submission = $this->submissionRepository->update($id, $request);
        return redirect('/backoffice/submission/cuti')->with('success', 'Cuti telah diubah');
    }

    public function deleteCuti($id)
    {
        $submission = $this->submissionRepository->delete($id);
        return redirect('/backoffice/submission/cuti')->with('success', 'Cuti telah dihapus');
    }

    // izin-sakit
    public function izinSakit()
    {
        $submissions = $this->submissionRepository->getAllNonTypeCuti();
        return view('backoffice.submission.izin-sakit.index', compact('submissions'));
    }

    public function storeIzinSakit(Request $request)
    {
        $submission = $this->submissionRepository->storeNonTypeCuti($request);
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Izin-sakit telah ditambahkan');
    }

    public function updateIzinSakit(Request $request, $id)
    {
        $submission = $this->submissionRepository->update($id, $request);
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Izin-sakit telah diubah');
    }

    public function deleteIzinSakit($id)
    {
        $submission = $this->submissionRepository->delete($id);
        return redirect('/backoffice/submission/izin-sakit')->with('success', 'Izin-sakit telah dihapus');
    }
}
