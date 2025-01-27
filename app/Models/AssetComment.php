<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AssetComment extends Pivot
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'asset_id',
        'user_id',
        'comment',
        'is_resolved',
        'metadata',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AssetComment::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(AssetComment::class, 'parent_id');
    }
}
