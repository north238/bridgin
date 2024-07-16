<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialiteLoginController extends Controller
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
            Log::alert("Google認証に失敗しました");
            Log::alert($e->getMessage());
            return redirect()->route('login')->withErrors(['error' => 'google認証に失敗しました']);
        }
    }

    /**
     * Github認証のリダイレクト処理
     *
     * @return \Illuminate\Http\RedirectResponse Github認証のリダイレクト
     * @throws \Illuminate\Support\Facades\Auth\AuthenticationException Github認証できなかった場合
     */
    public function redirectToGithub()
    {
        try {
            return Socialite::driver('github')->redirect();
        } catch (\Exception $e) {
            Log::alert("Github認証に失敗しました");
            Log::alert($e->getMessage());
            return redirect()->route('login')->withErrors(['error' => 'Github認証に失敗しました']);
        }
    }

    /**
     * 認証のコールバック処理
     *
     * @throws \Exception ユーザー情報を取得する際にエラーが発生した場合
     * @return \Illuminate\Http\RedirectResponse エラーメッセージを含むログインページへのリダイレクトレスポンス
     */
    public function handleSocialiteCallback($provider)
    {
        try {
            $socialiteUser = Socialite::driver($provider)->user();

            // ユーザー情報をDBから取得
            $user = $this->users->getUserInfo($provider, $socialiteUser->id, $socialiteUser->email);
            // 登録されていないユーザーの場合は新規登録
            if ($user === null) {
                $user = $this->createUserByGoogle($provider, $socialiteUser);
            }

            Auth::login($user);

            return redirect()->route('assets.dashboard'); // ログイン後の遷移先
        } catch (\Exception $e) {
            Log::alert("認証に失敗しました: handleSocialiteCallback");
            Log::alert($e->getMessage());
            return redirect()->route('login')->withErrors(['error' => '認証に失敗しました。']);
        }
    }

    /**
     * 取得したユーザー情報をDBに保存する
     *
     *  @param $provider 認証プロバイダ
     *  @param $socialiteUser 取得したユーザー情報
     *  @return void
     */
    public function createUserByGoogle($provider, $socialiteUser)
    {
        $user = User::create([
            'name' => $socialiteUser->name,
            'email' => $socialiteUser->email,
            'provider' => $provider,
            'provider_id' => $socialiteUser->id,
            'password' => Hash::make($socialiteUser->id),
            'token' => $socialiteUser->token,
        ]);

        event(new Registered($user));
        return $user;
    }
}
