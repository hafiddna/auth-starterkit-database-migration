<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'code',
        'locale',
        'is_rtl',
        'icon_id',
    ];

    public $timestamps = false;

    public function icon(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'icon_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class, 'language_locale', 'locale');
    }
}
