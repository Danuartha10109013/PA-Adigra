<?php

namespace App\Http\Controllers;

use App\Http\Repository\AuthRepository;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\Auth\ForgotPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginAction(LoginRequest $request)
    {

        // check if email no registered
        $user = $this->authRepository->getByEmail($request);
        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar');
        }

        // check if password not match
        if (!password_verify($request->password, $user->password)) {
            return back()->with('error', 'Password tidak sesuai');
        }

        // check if email not verified
        if (!$user->email_verified_at) {
            return back()->with('error', 'Email belum diverifikasi, silahkan cek email anda');
        }

        // login success
        $request->session()->regenerate();
        Auth::login($user);
        return redirect()->intended('/backoffice/dashboard');

    }

    public function verify($token)
    {
        $user = $this->authRepository->getByToken($token);
        if ($user) {
            // $user->remember_token = null;
            $user->email_verified_at = now();
            $user->save();
            return redirect('/')->with('success', 'Akun anda telah diverifikasi. Silahkan masuk');
        } else {
            abort(404);
        }
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordAction(ForgotPasswordRequest $request)
    {

        $user = $this->authRepository->getByEmail($request);
        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar');
        }

        $user->remember_token = Str::random(40);
        $user->save();

        Mail::to($user->email)->send(new ForgotPasswordMail($user));

        return redirect()->back()->with('success', 'Silahkan cek email anda untuk mengatur ulang password');
    }

    public function resetPassword($token)
    {
        $user = $this->authRepository->getByToken($token);
        if ($user) {
            return view('auth.reset-password', compact('user', 'token'));
        } else {
            abort(404);
        }
    }

    public function resetPasswordAction(ResetPasswordRequest $request, $token)
    {

        $user = $this->authRepository->getByToken($token);
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->update();
            // return redirect()->back();
            return redirect('/login')->with('success', 'Password anda telah di atur ulang. Silahkan masuk');
        } else {
            abort(404);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
