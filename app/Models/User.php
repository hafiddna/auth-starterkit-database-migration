<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    public $timestamps = false;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'username',
        'password',
        'pin',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'is_active',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'pin',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'pin' => 'hashed',
        ];
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user')->using(TeamUser::class);
    }

    public function ownTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function userSetting(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role')->using(UserRole::class);
    }

    public function passwordTokens(): HasMany
    {
        return $this->hasMany(DB::table('password_reset_tokens'));
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(DB::table('sessions'));
    }

    public function assignRole(string $role): void
    {
        $this->roles()->attach(Role::where('name', $role)->first());
    }

    public function assetShares(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class, 'asset_share')->using(AssetShare::class);
    }

    public function assetComments(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class, 'asset_comment')->using(AssetComment::class);
    }

    public function folders(): MorphMany
    {
        return $this->morphMany(Folder::class, 'owner');
    }

    public function assets(): MorphMany
    {
        return $this->morphMany(Asset::class, 'owner');
    }

    public function securityAnswers(): BelongsToMany
    {
        return $this->belongsToMany(SecurityQuestion::class, 'user_security_answers')->using(UserSecurityAnswer::class);
    }
}
