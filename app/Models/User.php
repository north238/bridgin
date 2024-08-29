<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        'provider',
        'provider_id',
        'provider_token',
        'provider_refresh_token'
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

    /**
     * ユーザーが所有するアセットとのリレーションシップを定義
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    /**
     * ユーザーが投稿したコメントとのリレーションシップを定義
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userComments(): HasMany
    {
        return $this->hasMany(UserComment::class);
    }

    /**
     * ユーザーが関連するアセットターゲットとのリレーションシップを定義
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assetTargets(): HasMany
    {
        return $this->hasMany(AssetTarget::class);
    }

    /**
     * ユーザーが所有するアセットスイッチステータスとのリレーションシップを定義
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assetSwitchStatuses(): HasMany
    {
        return $this->hasMany(AssetSwitchStatus::class);
    }
    /**
     * ユーザーが持つお知らせとのリレーションシップを定義
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notifications(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class, 'notification_user')->withPivot('read_at')->withTimestamps();
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
            ->where('provider_token', '!=', null)
            ->first();

        return $result;
    }
}
