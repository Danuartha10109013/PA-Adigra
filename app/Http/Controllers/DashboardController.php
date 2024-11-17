<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        if (Auth::user()->role_id != 1) {
            return redirect('/backoffice/absent/create');
        }

        return view('backoffice.dashboard.index');
    }
}
