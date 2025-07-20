<?php

namespace App\Services;

use App\Models\Absent;
use App\Models\AttendanceSummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AttendanceSummaryService
{
    public function createFromAbsent(Absent $absent)
    {
        try {
            // Cek apakah sudah ada rekapitulasi untuk tanggal dan user ini
            $existingSummary = AttendanceSummary::where('user_id', $absent->user_id)
                ->whereDate('date', $absent->date)
                ->first();

            if ($existingSummary) {
                return $this->updateFromAbsent($existingSummary, $absent);
            }

            // Hitung status berdasarkan waktu absen
            $isLate = false;
            $isEarlyLeave = false;
            $isAbsent = false;
            $isLeave = false;
            $leaveType = null;

            // Cek status dari absen
            if ($absent->status === 'cuti') {
                $isLeave = true;
                $isAbsent = false;
                $leaveType = 'cuti';
            } elseif ($absent->status === 'izin') {
                $isLeave = false;
                $isAbsent = true;
                $leaveType = 'izin';
            } elseif ($absent->status === 'sakit') {
                $isLeave = false;
                $isAbsent = true;
                $leaveType = 'sakit';
            } else {
                // Cek keterlambatan berdasarkan waktu shift
                if ($absent->start && $absent->shift) {
                    $checkInTime = Carbon::parse($absent->start);
                    $shiftStart = Carbon::parse($absent->shift->start);
                    $isLate = $checkInTime->format('H:i') > $shiftStart->format('H:i');
                    Log::info('Check-in time: ' . $checkInTime->format('H:i') . 
                             ', Shift start: ' . $shiftStart->format('H:i') . 
                             ', Is Late: ' . ($isLate ? 'Yes' : 'No'));
                }

                // Cek pulang awal berdasarkan waktu shift
                if ($absent->end && $absent->shift) {
                    $checkOutTime = Carbon::parse($absent->end);
                    $shiftEnd = Carbon::parse($absent->shift->end);
                    $isEarlyLeave = $checkOutTime->format('H:i') < $shiftEnd->format('H:i');
                    Log::info('Check-out time: ' . $checkOutTime->format('H:i') . 
                             ', Shift end: ' . $shiftEnd->format('H:i') . 
                             ', Is Early Leave: ' . ($isEarlyLeave ? 'Yes' : 'No'));
                }
            }

            // Buat rekapitulasi baru
            $summary = AttendanceSummary::create([
                'user_id' => $absent->user_id,
                'date' => $absent->date,
                'check_in' => $absent->start,
                'check_out' => $absent->end,
                'is_late' => $isLate,
                'is_early_leave' => $isEarlyLeave,
                'is_absent' => $isAbsent,
                'is_leave' => $isLeave,
                'leave_type' => $leaveType,
                'notes' => $absent->description
            ]);

            Log::info('Created attendance summary for user ' . $absent->user_id . ' on ' . $absent->date);
            return $summary;

        } catch (\Exception $e) {
            Log::error('Error in createFromAbsent: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateFromAbsent(AttendanceSummary $summary, Absent $absent)
    {
        try {
            // Hitung status berdasarkan waktu absen
            $isLate = false;
            $isEarlyLeave = false;
            $isAbsent = false;
            $isLeave = false;
            $leaveType = null;

            // Cek status dari absen
            if ($absent->status === 'cuti') {
                $isLeave = true;
                $isAbsent = false;
                $leaveType = 'cuti';
            } elseif ($absent->status === 'izin') {
                $isLeave = false;
                $isAbsent = true;
                $leaveType = 'izin';
            } elseif ($absent->status === 'sakit') {
                $isLeave = false;
                $isAbsent = true;
                $leaveType = 'sakit';
            } else {
                // Cek keterlambatan berdasarkan waktu shift
                if ($absent->start && $absent->shift) {
                    $checkInTime = Carbon::parse($absent->start);
                    $shiftStart = Carbon::parse($absent->shift->start);
                    $isLate = $checkInTime->format('H:i') > $shiftStart->format('H:i');
                    Log::info('Updated check-in time: ' . $checkInTime->format('H:i') . 
                             ', Shift start: ' . $shiftStart->format('H:i') . 
                             ', Is Late: ' . ($isLate ? 'Yes' : 'No'));
                }

                // Cek pulang awal berdasarkan waktu shift
                if ($absent->end && $absent->shift) {
                    $checkOutTime = Carbon::parse($absent->end);
                    $shiftEnd = Carbon::parse($absent->shift->end);
                    $isEarlyLeave = $checkOutTime->format('H:i') < $shiftEnd->format('H:i');
                    Log::info('Updated check-out time: ' . $checkOutTime->format('H:i') . 
                             ', Shift end: ' . $shiftEnd->format('H:i') . 
                             ', Is Early Leave: ' . ($isEarlyLeave ? 'Yes' : 'No'));
                }
            }

            // Update rekapitulasi
            $summary->update([
                'check_in' => $absent->start,
                'check_out' => $absent->end,
                'is_late' => $isLate,
                'is_early_leave' => $isEarlyLeave,
                'is_absent' => $isAbsent,
                'is_leave' => $isLeave,
                'leave_type' => $leaveType,
                'notes' => $absent->description
            ]);

            Log::info('Updated attendance summary for user ' . $absent->user_id . ' on ' . $absent->date);
            return $summary;

        } catch (\Exception $e) {
            Log::error('Error in updateFromAbsent: ' . $e->getMessage());
            throw $e;
        }
    }
} 