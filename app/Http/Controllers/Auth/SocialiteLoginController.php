<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Mail\MailSender;
use Illuminate\Support\Facades\Mail;

class SocialiteLoginController extends Controller
{
    private $users;
    public function __construct(User $users)
    {
        $this->users = $users;
    }
    /**
     * 認証のリダイレクト処理
     *
     * @param string $provider 認証プロバイダー
     * @return \Illuminate\Http\RedirectResponse 認証のリダイレクト
     * @throws \Illuminate\Support\Facades\Auth\AuthenticationException 認証できなかった場合
     */
    public function redirectToProvider($provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            Log::alert(["error-message" => $provider . "認証に失敗しました", "getMessage" => $e->getMessage()]);
            return redirect()->route('login')->with(['error-message' => $provider . '認証に失敗しました']);
        }
    }

    /**
     * 認証のコールバック処理
     *
     * @param string $provider 認証プロバイダー
     * @throws \Exception ユーザー情報を取得する際にエラーが発生した場合
     * @return \Illuminate\Http\RedirectResponse エラーメッセージを含むログインページへのリダイレクトレスポンス
     */
    public function handleSocialiteCallback($provider)
    {
        try {
            DB::beginTransaction();
            // 認証情報を取得する
            $socialiteUser = Socialite::driver($provider)->user();

            $user = $this->loginUserCheck($provider, $socialiteUser);
            if (empty($user)) {
                $user = $this->createUserByProvider($provider, $socialiteUser);
                // adminにメール送信
                Mail::to(config('mail.admin'))->send(new MailSender($user));
            }

            Auth::login($user);
            // セッションIDを生成する
            Session::regenerate();
            DB::commit();

            return redirect()->intended('dashboard')->with(['success-message' => $user->name . 'さん、ようこそ。資産管理を始めましょう']);
        } catch (\Exception $e) {
            Log::alert(["error-message" => "認証に失敗しました: handleSocialiteCallback", "getMessage" => $e->getMessage()]);
            DB::rollBack();
            return redirect()->route('login')->with(['error-message' => $provider . '認証に失敗しました。既に登録済みの可能性があります。']);
        }
    }

    /**
     * 取得したユーザー情報をDBに保存する
     *
     * @param string $provider 認証プロバイダ
     * @param \Laravel\Socialite\Contracts\User $socialiteUser 取得したユーザー情報
     * @return \App\Models\User
     */
    private function createUserByProvider($provider, $socialiteUser)
    {
        $user = $this->users->updateOrCreate([
            'email' => $socialiteUser->getEmail(),
            'provider' => $provider,
        ], [
            'name' => $socialiteUser->getName(),
            'password' => Hash::make($socialiteUser->getId()),
            'provider_id' => $socialiteUser->getId(),
            'provider_token' => $socialiteUser->token,
            'provider_refresh_token' => $socialiteUser->refreshToken
        ]);

        event(new Registered($user));
        return $user;
    }

    /**
     * 登録されているユーザーの場合の処理
     *
     * @param string $provider 認証プロバイダ
     * @param \Laravel\Socialite\Contracts\User $socialiteUser 取得したユーザー情報
     * @return \App\Models\User|null
     */
    private function loginUserCheck($provider, $socialiteUser)
    {
        $id = $socialiteUser->getId();
        $email = $socialiteUser->getEmail();

        // 登録されているユーザーの確認
        $user = $this->users->getUserInfo($provider, $id, $email);
        if (!empty($user)) {
            $this->updateToken($user, $socialiteUser);
        }
        return $user;
    }

    /**
     * ユーザーのトークンを更新する
     *
     * @param \App\Models\User $user ユーザーモデルインスタンス
     * @param \Laravel\Socialite\Contracts\User $socialiteUser Socialiteユーザーオブジェクト
     * @return void
     */
    private function updateToken($user, $socialiteUser)
    {
        $user->provider_token = $socialiteUser->token;

        // refreshTokenが存在する場合のみ更新
        if (!empty($socialiteUser->refreshToken)) {
            $user->provider_refresh_token = $socialiteUser->refreshToken;
        }

        try {
            DB::beginTransaction();
            $user->save();
            DB::commit();
        } catch (\Exception $e) {
            Log::alert(["error-message" => "認証に失敗しました: updateToken", "getMessage" => $e->getMessage()]);
            DB::rollBack();
            return redirect()->route('login')->with(['error-message' => __('update_token_error_message')]);
        }
    }
}
