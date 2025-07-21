<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meet extends Model
{
    protected $fillable = [
        'title',
        'date',
        'start',
        'end',
        'category',
        'notulensi',
        'status',
        'created_by',
        'status',
        'acc',
        'sik'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'meet_participants')
            ->withPivot('is_attended')
            ->withTimestamps();
    }
}
