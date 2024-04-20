<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * 管理者用パスワード作成
     */
    public function create(Request $request): View
    {
        return view('auth.admin.reset-password', ['request' => $request]);
    }

    /**
     * パスワードを新しく生成する
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ここでは、ユーザーのパスワードをリセットしてみます。成功すると、 
        // 実際のユーザー モデルのパスワードが更新され、 
        // データベースに永続化されます。それ以外の場合は、エラーを解析して応答を返します。
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // パスワードが正常にリセットされた場合、ユーザーは 
        // アプリケーションのホーム認証済みビューにリダイレクトされます。エラーが発生した場合は、 
        // エラーメッセージが表示された場所にリダイレクトできます。
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('admin/login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
