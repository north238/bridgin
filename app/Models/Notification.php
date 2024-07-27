<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // $fillable で指定された属性は、大量代入で指定可能
    protected $fillable = [
        'title',
        'body',
        'type',
        'expires_at',
        'priority',
        'metadata',
    ];

    // $casts で属性のデータ型を指定
    protected $casts = [
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * ユーザーとのリレーションシップを定義
     * このお知らせがどのユーザーに関連しているかを示します
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_user')->withPivot('read_at')->withTimestamps();
    }

    public function markNotificationAsRead($notificationId)
    {
        $this->notifications()->updateExistingPivot($notificationId, ['read_at' => now()]);
    }

    public function isNotificationRead($notificationId)
    {
        return $this->notifications()->where('notification_id', $notificationId)->whereNotNull('read_at')->exists();
    }
}
