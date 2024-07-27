<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

class NotificationMessageController extends Controller
{

    private $notifications;
    private $users;

    public function __construct(
        Notification $notifications,
        User $users
    ) {
        $this->notifications = $notifications;
        $this->users = $users;
    }

    /**
     * 初期表示画面
     */
    public function notificationIndex()
    {
        $notifications = $this->notifications;
        dd($notifications);
        return view('assets.notification-index');
    }
}
