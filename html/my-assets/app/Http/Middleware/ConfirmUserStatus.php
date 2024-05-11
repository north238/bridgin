<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ConfirmUserStatus
{
    /**
     * ユーザーが選択した設定を表示前に持たせる
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = Auth::id();
        $user = new User();
        $userStatusData = $user->confirmUserStatus($userId);
        if(empty($userStatusData) === true) {
            return $next($request);
        }
        $status = $userStatusData->assetSwitchStatuses->first();

        // データベースに値がなければ初期値に0を代入
        $debutStatus = $status->debut_status ?? 0;

        // 負債を表示・非表示を変数として渡す（0: 表示 1: 非表示）
        if(isset($debutStatus) === true){
            $request->merge(['debutStatus' => $debutStatus]);
        };
        return $next($request);
    }
}
