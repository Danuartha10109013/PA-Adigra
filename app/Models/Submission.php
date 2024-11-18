<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

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
