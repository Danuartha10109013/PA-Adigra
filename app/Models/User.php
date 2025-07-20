<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'minimum_work_hours',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function absents(): HasMany
    {
        return $this->hasMany(Absent::class, 'user_id', 'id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'user_id', 'id');
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function assesments(): HasMany
    {
        return $this->hasMany(Assesment::class, 'user_id', 'id');
    }

    /**
     * Hitung jam kerja hari ini
     */
    public function getWorkHoursToday()
    {
        $absentToday = $this->absents()
            ->whereDate('date', now()->format('Y-m-d'))
            ->where('status', 'Absen')
            ->first();

        if (!$absentToday || !$absentToday->start || !$absentToday->end) {
            return 0;
        }

        $start = Carbon::parse($absentToday->start);
        $end = Carbon::parse($absentToday->end);
        
        return $end->diffInMinutes($start);
    }

    /**
     * Cek apakah sudah memenuhi jam kerja minimal
     */
    public function hasMetMinimumWorkHours()
    {
        $workMinutes = $this->getWorkHoursToday();
        $requiredMinutes = $this->minimum_work_hours * 60;
        return $workMinutes >= $requiredMinutes;
    }

    /**
     * Dapatkan sisa jam kerja yang diperlukan
     */
    public function getRemainingWorkHours()
    {
        $workMinutes = $this->getWorkHoursToday();
        $requiredMinutes = $this->minimum_work_hours * 60;
        $remaining = $requiredMinutes - $workMinutes;
        return max(0, $remaining);
    }

    /**
     * Dapatkan format jam kerja yang sudah bekerja
     */
    public function getWorkHoursFormatted()
    {
        $workMinutes = $this->getWorkHoursToday();
        $workHours = floor($workMinutes / 60);
        $workMinutesRemaining = $workMinutes % 60;
        
        if ($workHours > 0) {
            return "{$workHours} jam {$workMinutesRemaining} menit";
        } else {
            return "{$workMinutesRemaining} menit";
        }
    }

    /**
     * Dapatkan format sisa jam kerja yang diperlukan
     */
    public function getRemainingWorkHoursFormatted()
    {
        $remainingMinutes = $this->getRemainingWorkHours();
        $remainingHours = floor($remainingMinutes / 60);
        $remainingMins = $remainingMinutes % 60;
        
        if ($remainingHours > 0) {
            return "{$remainingHours} jam {$remainingMins} menit";
        } else {
            return "{$remainingMins} menit";
        }
    }
}
