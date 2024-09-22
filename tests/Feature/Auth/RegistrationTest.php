<?php

namespace Tests\Feature\Auth;

use App\Http\Middleware\VerifyCsrfToken;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $user = [
            'user_name' => '山田 太郎',
            'email' => 'test.new.register.mail@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->withoutMiddleware([VerifyCsrfToken::class])->post('/register', $user);

        if ($response->getStatusCode() === 500) {
            $this->fail('サーバーエラーが発生しました: ' . $response->getContent());
        }

        $this->assertAuthenticated();

        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
