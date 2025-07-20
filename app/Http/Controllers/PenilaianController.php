<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index() {
        $users = User::where('role_id', 2)->orderBy('nilai_akhir', 'desc')->get();
        return view('backoffice.penilaian.index', compact('users'));
    }

    public function nilai(Request $request, $id) {
        $user = User::find($id);
        $user->kompetensi_teknis = $request->kompetensi_teknis;
        $user->kedisiplinan = $request->kedisiplinan;
        $user->sikap = $request->sikap;
        $user->produktivitas = $request->produktivitas;
        $user->kreativitas = $request->kreativitas;
        $user->kerjasama = $request->kerjasama;
        $user->komunikasi = $request->komunikasi;
        $user->nilai_akhir = $user->kompetensi_teknis + $user->kedisiplinan + $user->sikap + $user->produktivitas + $user->kreativitas + $user->kerjasama + $user->komunikasi;
        $user->save();
        return redirect()->back()->with('success', 'Penilaian telah diubah');
    }
}
