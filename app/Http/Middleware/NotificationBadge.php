<?php

namespace App\Http\Middleware;

use App\Models\Notification;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NotificationBadge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::user()->id;
        // 未読のお知らせを取得
        $unreadNotifications = Notification::getUnreadNotificationsByUser($userId);
        $unreadNotificationCount = $unreadNotifications->total();
        view()->share('unreadNotificationCount', $unreadNotificationCount);

        return $next($request);
    }
}
