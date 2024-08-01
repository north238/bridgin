<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use DateTime;
use Illuminate\Support\Facades\Auth;

class NotificationMessageController extends Controller
{
    /**
     * お知らせ一覧画面表示
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->show();
    }

    /**
     * 通知一覧を表示する
     *
     * @return \Illuminate\View\View
     */
    private function show()
    {
        $userId = Auth::user()->id;
        $notifications = Notification::getNotificationsByUser($userId);

        // 経過時間をフォーマット
        $notifications = $this->formatNotificationUpdateDates($notifications);
        $data = [
            'notifications' => $notifications
        ];

        return view('assets.notification-index', $data);
    }

    /**
     * 通知詳細画面を表示する
     *
     * @param int $notificationId お知らせID
     * @return \Illuminate\View\View
     */
    public function detail($notificationId)
    {
        $userId = Auth::user()->id;

        // 既読時間を更新
        Notification::markNotificationAsRead($userId, $notificationId);
        $notification = Notification::getNotification($notificationId);
        // 経過時間をフォーマット
        $notification = $this->formatNotificationUpdateDates($notification);
        return view('assets.notification-detail-index', ['notification' => $notification]);
    }

    /**
     * 通知の更新日と経過時間をフォーマットする
     *
     * @param mixed $notifications 通知コレクションまたは単一通知
     * @return mixed フォーマットされた通知情報を含むコレクションまたは単一通知
     */
    public function formatNotificationUpdateDates($notifications)
    {
        // コレクションの場合
        if ($notifications instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            foreach ($notifications as $notification) {
                $this->calculateElapsedTime($notification);
            }
        } else {
            // 単一の通知オブジェクトの場合
            $this->calculateElapsedTime($notifications);
        }
        return $notifications;
    }

    /**
     * 通知の時間を計算する
     *
     * @param \App\Models\Notification $notification 通知オブジェクト
     * @return void
     */
    public function calculateElapsedTime($notification)
    {
        $updateDate = new DateTime($notification->updated_at);
        $currentDate = new DateTime();

        $formattedDate = $updateDate->format('Y.n.d');
        $interval = $updateDate->diff($currentDate);

        // 各単位の経過時間を取得し、0の場合は表示しない
        $elapsedTimeParts = [];
        if ($interval->y > 0) {
            $elapsedTimeParts[] = $interval->y . '年';
        } else if ($interval->m > 0) {
            $elapsedTimeParts[] = $interval->m . 'ヶ月';
        } else if ($interval->d > 0) {
            $elapsedTimeParts[] = $interval->d . '日';
        } else if ($interval->h > 0) {
            $elapsedTimeParts[] = $interval->h . '時間';
        } else if ($interval->i > 0) {
            $elapsedTimeParts[] = $interval->i . '分';
        }

        // 経過時間が0秒の場合は「たった今」と表示
        $elapsedTime = empty($elapsedTimeParts) ? 'たった今' : implode(' ', $elapsedTimeParts) . '前';

        $notification->elapsedTime = $elapsedTime;
        $notification->formattedDate = $formattedDate;
    }
}
