<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationMessageController extends Controller
{
    public function notificationIndex()
    {
        return view('assets.notification-index');
    }
}
