<?php

namespace App\Http\Controllers;

use App\Http\Repository\DivisionRepository;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    private $divisionRepository;

    public function __construct(DivisionRepository $divisionRepository)
    {
        $this->divisionRepository = $divisionRepository;
    }

    public function index()
    {
        $divisions = $this->divisionRepository->getAll();
        return view('backoffice.master-data.division.index', compact('divisions'));
    }

    public function create(Request $request)
    {
        $this->divisionRepository->store($request);
        return redirect()->back()->with('success', 'Divisi telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $this->divisionRepository->update($request, $id);
        return redirect()->back()->with('success', 'Divisi telah diubah');
    }

    public function delete($id)
    {
        $this->divisionRepository->delete($id);
        return redirect()->back()->with('success', 'Divisi telah di hapus');
    }

}
