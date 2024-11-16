<?php

namespace App\Http\Repository;

use App\Models\User;

class AuthRepository
{
    
    public function getByEmail($request)
    {
        try {
            return User::where('email', $request->email)->first();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getByToken($token)
    {
        try {
            return User::where('remember_token', $token)->first();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}