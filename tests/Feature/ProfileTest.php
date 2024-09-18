<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create([
            'email' => 'test.profile.mail@gmail.com',
        ]);

        $response = $this->withoutMiddleware([VerifyCsrfToken::class])
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create([
            'email' => 'test.profile.mail@gmail.com',
        ]);

        $response = $this->withoutMiddleware([VerifyCsrfToken::class])
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test.update.profile.mail@gmail.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test.update.profile.mail@gmail.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create([
            'email' => 'test.profile.mail@gmail.com',
        ]);

        $response = $this->withoutMiddleware([VerifyCsrfToken::class])
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create([
            'email' => 'test.profile.mail@gmail.com',
        ]);

        $response = $this->withoutMiddleware([VerifyCsrfToken::class])
            ->actingAs($user)
            ->delete('/profile', [
                'delete-name' => $user->name,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create([
            'email' => 'test.profile.mail@gmail.com',
        ]);

        $response = $this->withoutMiddleware([VerifyCsrfToken::class])
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'hogehoge',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'delete-name')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
