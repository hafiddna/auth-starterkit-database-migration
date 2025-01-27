<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class I18n extends Model
{
    use HasUuids;

    public $timestamps = false;

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }

    public function securityQuestions(): HasMany
    {
        return $this->hasMany(SecurityQuestion::class, 'question_id');
    }

    public function securityQuestionDescriptions(): HasMany
    {
        return $this->hasMany(SecurityQuestion::class, 'description_id');
    }
}
