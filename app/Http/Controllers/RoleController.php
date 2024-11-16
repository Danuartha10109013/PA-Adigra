<?php

namespace App\Http\Controllers;

use App\Http\Repository\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->getAll();
        return view('backoffice.user-data.role.index', compact('roles'));
    }

    public function create(Request $request)
    {
        $this->roleRepository->create($request);
        return redirect()->back()->with('success', 'Peran telah ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $this->roleRepository->update($request, $id);
        return redirect()->back()->with('success', 'Peran telah diubah');
    }
    
    public function delete($id)
    {
        $this->roleRepository->delete($id);
        return redirect()->back()->with('success', 'Peran telah di hapus');
    }

}
