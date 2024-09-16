<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        } else {
            if (Route::is('admin.*')) {
                return route('admin.login');
            }

            if (Route::is('verification.verify')) {
                Log::alert('Authenticate::redirectTo(), Path: ' . $request->path());
                return route('verification.notice');
            }

            Log::alert('Authenticate::redirectTo()認証が正しくないようです。Path: ' . $request->path());
            session()->flash('error-message', '認証に失敗しました。ログイン情報をご確認ください。');
            return route('login');
        }
    }
}
