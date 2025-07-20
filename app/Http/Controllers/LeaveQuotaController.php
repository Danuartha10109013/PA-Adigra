<?php

namespace App\Http\Controllers;

use App\Models\LeaveQuota;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveQuotaController extends Controller
{
    // Menampilkan daftar jatah cuti semua karyawan (filter tahun)
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $leaveQuotas = LeaveQuota::with('user')->yearly($year)->get();
        $users = User::all();
        return view('backoffice.leave-quota.index', compact('leaveQuotas', 'users', 'year'));
    }

    // Menambah jatah cuti untuk karyawan tertentu di tahun tertentu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'year' => 'required|integer|min:2020|max:2030',
            'quota' => 'required|integer|min:0|max:365',
        ]);

        LeaveQuota::updateOrCreate(
            [
                'user_id' => $validated['user_id'],
                'year' => $validated['year'],
            ],
            [
                'quota' => $validated['quota'],
                'used' => 0,
            ]
        );

        return redirect()->route('leave-quota.index')->with('success', 'Jatah cuti tahunan berhasil disimpan');
    }

    // Update jatah cuti (atau jumlah cuti yang sudah diambil)
    public function update(Request $request, $id)
    {
        $leaveQuota = LeaveQuota::findOrFail($id);
        $validated = $request->validate([
            'quota' => 'sometimes|integer|min:0|max:365',
            'used' => 'sometimes|integer|min:0',
        ]);
        $leaveQuota->update($validated);
        return redirect()->route('leave-quota.index')->with('success', 'Jatah cuti berhasil diupdate');
    }

    // Hapus data jatah cuti
    public function destroy($id)
    {
        $leaveQuota = LeaveQuota::findOrFail($id);
        $leaveQuota->delete();
        return redirect()->route('leave-quota.index')->with('success', 'Jatah cuti berhasil dihapus');
    }
} 