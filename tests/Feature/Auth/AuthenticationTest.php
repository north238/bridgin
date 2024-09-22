<?php

namespace Tests\Feature\Auth;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'email' => 'test.mail@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->withoutMiddleware([VerifyCsrfToken::class])->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_authentication_is_rate_limited(): void
    {
        $user = User::factory()->create([
            'email' => 'test.limited.mail@gmail.com',
        ]);

        $ip = '123.456.789.000';

        for ($i = 0; $i < 5; $i++) {
            $response = $this->withoutMiddleware([VerifyCsrfToken::class])->withHeaders([
                'X-Forwarded-For' => $ip,
                'User-Agent' => 'TestBrowser',
            ])->post('/login', [
                'email' => $user->email,
                'password' => 'wrong_password',
            ]);
        }

        $response = $this->withoutMiddleware([VerifyCsrfToken::class])->withHeaders([
            'X-Forwarded-For' => $ip,
            'User-Agent' => 'TestBrowser',
        ])->post('/login', [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(302);

        // リダイレクト先のコンテンツを取得
        $responseContent = $this->get('/login')->getContent();

        // メッセージがリダイレクト先のページに含まれていることを確認
        $this->assertStringContainsString('ログイン試行が多すぎます。', $responseContent);
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->withoutMiddleware([VerifyCsrfToken::class])->post('/logout', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
