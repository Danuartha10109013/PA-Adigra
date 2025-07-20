<?php

namespace App\Http\Controllers;

use App\Http\Repository\OfficeRepository;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    private $officeRepository;

    public function __construct(OfficeRepository $officeRepository)
    {
        $this->officeRepository = $officeRepository;
    }

    public function index()
    {
        $offices = $this->officeRepository->getAll();
        $office = Office::orderBy('id', 'desc')->first();
        return view('backoffice.office.index', compact('offices', 'office'));
    }

    public function create(Request $request)
    {
        $office = $this->officeRepository->store($request);
        return redirect()->back()->with('success', 'Kantor telah ditambahkan');
    }

    public function detail($id)
    {
        $office = $this->officeRepository->getById($id);
        return view('backoffice.office.detail', compact('office'));
    }

    public function update(Request $request, $id)
    {
        $office = $this->officeRepository->update($id, $request);
        return redirect()->back()->with('success', 'Kantor telah diperbarui');
    }

    public function delete($id)
    {
        $office = $this->officeRepository->delete($id);
        return redirect()->back()->with('success', 'Kantor telah dihapus');
    }
}
