<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Asset extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = [
        'owner_id',
        'owner_type',
        'name',
        'path',
        'size',
        'type',
        'access',
        'bucket_name',
        'is_public',
        'file_metadata',
        'metadata',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'file_metadata' => 'array',
        'metadata' => 'array',
    ];

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    public function userProfiles(): HasMany
    {
        return $this->hasMany(UserProfile::class, 'avatar_id');
    }

    public function languages(): HasMany
    {
        return $this->hasMany(Language::class, 'icon_id');
    }

    public function assetShares(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'asset_share')->using(AssetShare::class);
    }

    public function assetComments(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'asset_comment')->using(AssetComment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'asset_tag')->using(AssetTag::class);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
