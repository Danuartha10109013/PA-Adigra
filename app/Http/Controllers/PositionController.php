<?php

namespace App\Http\Controllers;

use App\Http\Repository\PositionRepository;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    
    private $positionRepository;

    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function index()
    {
        $positions = $this->positionRepository->getAll();
        return view('backoffice.master-data.position.index', compact('positions'));
    }

    public function create(Request $request)
    {
        $this->positionRepository->store($request);
        return redirect()->back()->with('success', 'Posisi telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $this->positionRepository->update($request, $id);
        return redirect()->back()->with('success', 'Posisi telah diubah');
    }

    public function delete($id)
    {
        $this->positionRepository->delete($id);
        return redirect()->back()->with('success', 'Posisi telah di hapus');
    }

}
