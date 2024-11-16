<?php

namespace App\Http\Controllers;

use App\Http\Repository\ShiftRepository;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    
    private $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function index()
    {
        $shifts = $this->shiftRepository->getAll();
        return view('backoffice.shift.index', compact('shifts'));
    }

    public function create(Request $request)
    {
        $this->shiftRepository->store($request);
        return redirect()->back()->with('success', 'Shift telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $this->shiftRepository->update($request, $id);
        return redirect()->back()->with('success', 'Shift telah diubah');
    }

    public function delete($id)
    {
        $this->shiftRepository->delete($id);
        return redirect()->back()->with('success', 'Shift telah di hapus');
    }

}
