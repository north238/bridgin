<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notification_user')->withPivot('read_at')->withTimestamps();
    }

    /**
     * ユーザーIDに基づいて通知を取得
     *
     * @param int $userId ユーザーID
     * @param int $limit 表示件数
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNotificationsByUser($userId)
    {
        $result = User::findOrFail($userId)
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $result;
    }

    /**
     * ユーザーの通知を既読としてマークする
     *
     * @param int $userId ユーザーID
     * @param int $notificationId 通知ID
     * @return bool 更新が成功したかどうか
     */
    public static function markNotificationAsRead($userId, $notificationId)
    {
        $user = User::findOrFail($userId);
        return $user->notifications()->updateExistingPivot($notificationId, ['read_at' => now()]);
    }

    /**
     * ユーザーIDに基づいて未読の通知を取得
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUnreadNotificationsByUser($userId)
    {
        return User::findOrFail($userId)->notifications()->wherePivot('read_at', null)->get();
    }

    /**
     * 指定されたお知らせを取得
     */
    public static function getNotification($notificationId)
    {
        return Notification::find($notificationId);
    }
}
