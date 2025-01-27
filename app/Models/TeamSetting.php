<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;

class TeamSetting extends Model
{
    protected $connection = 'mongodb';

    public $timestamps = false;

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
