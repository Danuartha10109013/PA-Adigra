<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSummary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceSummaryController extends Controller
{
    public function index(Request $request)
    {
        $absents = \App\Models\Absent::with('user')
            ->when($request->filled('start_date'), fn($q) => $q->whereDate('date', '>=', $request->start_date))
            ->when($request->filled('end_date'), fn($q) => $q->whereDate('date', '<=', $request->end_date))
            ->when($request->filled('user_id'), fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->filled('jenis_absen'), function($q) use ($request) {
                if ($request->jenis_absen === 'wfh') {
                    $q->whereRaw('LOWER(status) = ?', ['wfh']);
                } elseif ($request->jenis_absen === 'wfo') {
                    $q->where(function($q) {
                        $q->whereRaw('LOWER(status) = ?', ['absen'])
                          ->orWhereRaw('LOWER(status) = ?', ['wfo']);
                    });
                }
            })
            ->orderBy('date', 'desc')
            ->get();
        $users = User::all();
        return view('backoffice.attendance.summary.index', compact('absents', 'users'));
    }

    public function create()
    {
        $users = User::all();
        return view('backoffice.attendance.summary.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'is_late' => 'boolean',
            'is_early_leave' => 'boolean',
            'is_absent' => 'boolean',
            'is_leave' => 'boolean',
            'leave_type' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        AttendanceSummary::create($validated);

        return redirect()->route('attendance.summary.index')
            ->with('success', 'Rekapitulasi absensi berhasil ditambahkan');
    }

    public function edit(Request $request, $id)
    {
        try {
            $summary = AttendanceSummary::findOrFail($id);
            $users = User::all();
            return view('backoffice.attendance.summary.edit', compact('summary', 'users'));
        } catch (\Exception $e) {
            return redirect()->route('attendance.summary.index')
                ->with('error', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $summary = AttendanceSummary::findOrFail($id);
            
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'is_late' => 'boolean',
                'is_early_leave' => 'boolean',
                'is_absent' => 'boolean',
                'is_leave' => 'boolean',
                'leave_type' => 'nullable|string|max:255',
                'notes' => 'nullable|string'
            ]);

            $summary->update($validated);

            return redirect()->route('attendance.summary.index')
                ->with('success', 'Rekapitulasi absensi berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('attendance.summary.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $summary = AttendanceSummary::findOrFail($id);
            
            // Hapus data
            $summary->delete();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Data rekapitulasi absensi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function report(Request $request)
    {
        $query = AttendanceSummary::with('user')
            ->when($request->filled('start_date'), function ($q) use ($request) {
                return $q->whereDate('date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                return $q->whereDate('date', '<=', $request->end_date);
            })
            ->when($request->filled('user_id'), function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            });
        $summaries = $query->get();
        $users = User::all();

        // Ambil data absents untuk status dan bukti_foto
        $absentsQuery = \App\Models\Absent::query()
            ->select(['user_id','date','status','bukti_foto'])
            ->when($request->filled('start_date'), function ($q) use ($request) {
                return $q->whereDate('date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                return $q->whereDate('date', '<=', $request->end_date);
            })
            ->when($request->filled('user_id'), function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            });
        if ($request->jenis_absen === 'wfh') {
            $absentsQuery->whereRaw('LOWER(status) = ?', ['wfh']);
        } elseif ($request->jenis_absen === 'wfo') {
            $absentsQuery->where(function($q) {
                $q->whereRaw('LOWER(status) = ?', ['absen'])
                  ->orWhereRaw('LOWER(status) = ?', ['wfo']);
            });
        }
        $absents = $absentsQuery->get();
        $absentsMap = $absents->keyBy(function($item) {
            return $item->user_id.'_'.$item->date;
        });

        // Gabungkan status dan bukti_foto ke summaries
        foreach ($summaries as $summary) {
            $key = $summary->user_id.'_'.$summary->date->format('Y-m-d');
            if (isset($absentsMap[$key])) {
                $summary->status = $absentsMap[$key]->status;
                $summary->bukti_foto = $absentsMap[$key]->bukti_foto;
            } else {
                $summary->status = null;
                $summary->bukti_foto = null;
            }
        }

        // Tambahkan data meeting keluar kota
        $meetings = \App\Models\Meet::with(['participants'])
            ->where('category', 'out_of_town')
            ->where('status', '!=', 'cancelled')
            ->when($request->filled('start_date'), function ($q) use ($request) {
                return $q->whereDate('date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                return $q->whereDate('date', '<=', $request->end_date);
            })
            ->when($request->filled('user_id'), function ($q) use ($request) {
                return $q->whereHas('participants', function($query) use ($request) {
                    $query->where('user_id', $request->user_id);
                });
            })
            ->get();
        foreach ($meetings as $meeting) {
            foreach ($meeting->participants as $participant) {
                $summary = new AttendanceSummary([
                    'user_id' => $participant->id,
                    'date' => $meeting->date,
                    'is_leave' => true,
                    'leave_type' => 'Meeting Keluar Kota',
                    'notes' => 'Meeting keluar kota: ' . $meeting->title,
                    'status' => $meeting->status,
                    'bukti_foto' => null
                ]);
                $summary->user = $participant;
                $summaries->push($summary);
            }
        }

        $absentsAll = \App\Models\Absent::query()
            ->when($request->filled('start_date'), function ($q) use ($request) {
                return $q->whereDate('date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                return $q->whereDate('date', '<=', $request->end_date);
            })
            ->when($request->filled('user_id'), function ($q) use ($request) {
                return $q->where('user_id', $request->user_id);
            })
            ->get();

        $report = $summaries->groupBy('user_id')->map(function ($items, $user_id) use ($absentsAll) {
            $userAbsents = $absentsAll->where('user_id', $user_id);
            $total_wfh = $userAbsents->where(function($a){ return strtolower($a->status) == 'wfh'; })->count();
            $total_wfo = $userAbsents->where(function($a){ return strtolower($a->status) == 'absen' || strtolower($a->status) == 'wfo'; })->count();
            return [
                'user' => $items->first()->user,
                'total_days' => $items->count(),
                'total_late' => $items->where('is_late', true)->count(),
                'total_early_leave' => $items->where('is_early_leave', true)->count(),
                'total_absent' => $items->where('is_absent', true)->count(),
                'total_leave' => $items->where('is_leave', true)->count(),
                'total_meeting' => $items->where('leave_type', 'Meeting Keluar Kota')->count(),
                'total_wfh' => $total_wfh,
                'total_wfo' => $total_wfo
            ];
        });

        return view('backoffice.attendance.summary.report', compact('report', 'users'));
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            
            $summary = AttendanceSummary::findOrFail($id);
            
            // Hapus data
            $summary->delete();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Data rekapitulasi absensi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
} 