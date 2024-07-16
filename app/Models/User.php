<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'google_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function userComments(): HasMany
    {
        return $this->hasMany(UserComment::class);
    }

    public function assetTargets(): HasMany
    {
        return $this->hasMany(AssetTarget::class);
    }

    public function assetSwitchStatuses(): HasMany
    {
        return $this->hasMany(AssetSwitchStatus::class);
    }

    /**
     * ユーザーのステータスを取得する
     * @param  int   $userId
     * @return query $result
     */
    public function confirmUserStatus($userId)
    {
        $result = User::query()
            ->with('assetSwitchStatuses')
            ->where('id', $userId)
            ->first();

        return $result;
    }

    /**
     * ユーザー情報を取得する
     * @param string $providerId 認証プロバイダID
     * @param string $email メールアドレス
     * @return query $result
     */
    public function getUserInfo($provider, $providerId, $email)
    {
        $result = User::query()
            ->where('provider', $provider)
            ->where('provider_id', $providerId)
            ->where('email', $email)
            ->where('token', '!=', null)
            ->first();

        return $result;
    }
}
