<?php

namespace App\Models;

use App\Services\AttendanceSummaryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Absent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'office_id',
        'start',
        'end',
        'latitude',
        'longitude',
        'status',
        'description',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
        'start' => 'datetime',
        'end' => 'datetime'
    ];

    protected static function booted()
    {
        static::created(function ($absent) {
            try {
                $service = app(AttendanceSummaryService::class);
                $service->createFromAbsent($absent);
            } catch (\Exception $e) {
                Log::error('Error creating attendance summary: ' . $e->getMessage());
            }
        });

        static::updated(function ($absent) {
            try {
                $service = app(AttendanceSummaryService::class);
                $service->createFromAbsent($absent);
            } catch (\Exception $e) {
                Log::error('Error updating attendance summary: ' . $e->getMessage());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    // set createdAt to format
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->locale('id')->isoFormat('dddd, D MMMM YYYY');
    }

    // set updatedAt to format
    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->locale('id')->isoFormat('dddd, D MMMM YYYY');
    }
}
