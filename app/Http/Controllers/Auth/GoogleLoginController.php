<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleLoginController extends Controller
{
    private $users;
    public function __construct(User $users)
    {
        $this->users = $users;
    }
    /**
     * Google認証のリダイレクト処理
     *
     * @return \Illuminate\Http\RedirectResponse Google認証のリダイレクト
     * @throws \Illuminate\Support\Facades\Auth\AuthenticationException Google認証できなかった場合
     */
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            return redirect()->route('login')->withErrors(['error' => 'Failed to authenticate with Google.']);
        }
    }

    /**
     * Google認証のコールバック処理
     *
     * @throws \Exception Googleからユーザー情報を取得する際にエラーが発生した場合
     * @return \Illuminate\Http\RedirectResponse エラーメッセージを含むログインページへのリダイレクトレスポンス
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            return redirect()->route('login')->withErrors(['error' => 'google認証に失敗しました。']);
        }

        // 登録されていないユーザーの場合は新規登録
        if (!$this->users->getUserInfo($googleUser)) {
            $this->createUserByGoogle($googleUser);
        }

        return redirect('assets.dashboard'); // ログイン後の遷移先
    }

    /**
     * Googleから取得したユーザー情報をDBに保存する
     *
     *  @param $googleUser Googleから取得したユーザー情報
     *  @return void
     */
    public function createUserByGoogle($googleUser)
    {
        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'password' => Hash::make($googleUser->id),
            'google_token' => $googleUser->token,
        ]);

        event(new Registered($user));
        Auth::login($user);
    }
}
