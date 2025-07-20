<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveQuota extends Model
{
    use HasFactory;

    protected $table = 'leave_quotas';

    protected $fillable = [
        'user_id',
        'year',
        'month',
        'quota',
        'used',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk mendapatkan jatah cuti tahunan
     */
    public function scopeYearly($query, $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Scope untuk mendapatkan jatah cuti bulanan (jika diperlukan)
     */
    public function scopeMonthly($query, $year, $month)
    {
        return $query->where('year', $year)->where('month', $month);
    }
} 