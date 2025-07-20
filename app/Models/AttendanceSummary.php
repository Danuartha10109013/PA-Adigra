<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
        'is_late',
        'is_early_leave',
        'is_absent',
        'is_leave',
        'leave_type',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'is_late' => 'boolean',
        'is_early_leave' => 'boolean',
        'is_absent' => 'boolean',
        'is_leave' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 