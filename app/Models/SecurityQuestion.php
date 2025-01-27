<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SecurityQuestion extends Model
{
    public $timestamps = false;

    use HasUuids;

    protected $fillable = [
        'question_id',
        'description_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function userSecurityAnswers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_security_answers')->using(UserSecurityAnswer::class);
    }

    public function i18nQuestion(): BelongsTo
    {
        return $this->belongsTo(I18n::class, 'question_id');
    }

    public function i18nDescription(): BelongsTo
    {
        return $this->belongsTo(I18n::class, 'description_id');
    }
}
