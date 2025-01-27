<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Translation extends Model
{
    use HasUuids;

    protected $fillable = [
        'i18n_id',
        'language_locale',
        'value',
    ];

    public $timestamps = false;

    public function i18n(): BelongsTo
    {
        return $this->belongsTo(I18n::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_locale', 'locale');
    }
}
