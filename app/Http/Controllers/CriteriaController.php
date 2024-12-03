<?php

namespace App\Http\Controllers;

use App\Http\Repository\CriteriaRepository;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    private $criteriaRepository;

    public function __construct(CriteriaRepository $criteriaRepository)
    {
        $this->criteriaRepository = $criteriaRepository;
    }

    public function index()
    {
        $criterias = $this->criteriaRepository->getAll();
        return view('backoffice.assesment-data.criteria.index', compact('criterias'));
    }

    public function create(Request $request)
    {
        $this->criteriaRepository->store($request);
        return redirect()->back()->with('success', 'Kriteria telah ditambahkan');
    }

    public function update(Request $request, $id)   
    {
        $this->criteriaRepository->update($id, $request);
        return redirect()->back()->with('success', 'Kriteria telah diubah');
    }

    public function delete($id)
    {
        $this->criteriaRepository->delete($id);
        return redirect()->back()->with('success', 'Kriteria telah dihapus');
    }
}
