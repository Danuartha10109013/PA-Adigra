<?php

namespace App\Http\Controllers;

use App\Http\Repository\RoleRepository;
use App\Http\Repository\UserRepository;
use App\Http\Requests\User\CreateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepository;
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->customGetAll($request);
        return view('backoffice.user-data.user.index', $users);
    }

    public function create(CreateRequest $request)
    {

        try {
            $user = $this->userRepository->store($request);
            return redirect('/backoffice/user-data/user')->with('success', 'Data pengguna telah ditambahkan, beritahu ' . $user->name . ' untuk melakukan verifikasi akun');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function profile($id)
    {
        try {
            $user = $this->userRepository->getById($id);
            return view('backoffice.user-data.user.profile', compact('user'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editData($id)
    {

        try {
            $user = $this->userRepository->getById($id);
            return view('backoffice.user-data.user.edit-data', compact('user'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateData(Request $request, $id)
    {
        try {
            // dd($request->all());

            $user = $this->userRepository->updateData($request, $id);
            return redirect()->back()->with('success', 'Data profil telah diubah');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editPassword($id)
    {
        try {
            $user = $this->userRepository->getById($id);
            return view('backoffice.user-data.user.edit-password', compact('user'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updatePassword(Request $request, $id)
    {        
        $request->validate([
            'password_sekarang' => 'required',
            'password_baru' => 'required|min:8|regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
            'konfirmasi_password' => 'required|min:8|regex:/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/|same:password_baru',
        ], [
            'password_sekarang.required' => 'Password sekarang harus diisi',
            'password_baru.required' => 'Password baru harus diisi',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.regex' => 'Password baru harus terdiri dari huruf kecil, huruf besar, dan angka',
            'konfirmasi_password.required' => 'Konfirmasi password harus diisi',
            'konfirmasi_password.regex' => 'Password harus terdiri dari huruf kecil, huruf besar, dan angka',
            'konfirmasi_password.min' => 'Password minimal 8 karakter',
            'konfirmasi_password.same' => 'Password baru dan konfirmasi password tidak sama',
        ]);

        $user = $this->userRepository->getById($id);
        if (!Hash ::check($request->password_sekarang, $user->password)) {
            return redirect()->back()->with('error', 'Password sekarang tidak sesuai');
        } 

        $this->userRepository->updatePassword($request, $id);
        return redirect()->back()->with('success', 'Password telah diubah');
    }
}
