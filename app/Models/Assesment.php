<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assesment extends Model
{
    protected $table = 'assesments';

    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class, 'criteria_id', 'id');
    }
}
