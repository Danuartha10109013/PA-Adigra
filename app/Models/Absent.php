<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absent extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
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
