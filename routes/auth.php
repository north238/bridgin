<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', 'check.browser'])->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // social認証（google, github)
    Route::get('auth/login/{provider}', [SocialiteLoginController::class, 'authenticateReturningUser'])->name('login.return');

    Route::get('auth/{provider}/redirect', [SocialiteLoginController::class, 'redirectToProvider'])->name('login.provider');

    Route::get('auth/callback/{provider}', [SocialiteLoginController::class, 'handleSocialiteCallback'])->name('login.callback');
});

Route::middleware('auth')->group(function () {

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // メール認証（メールが送信される前にログインしている状態）
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1', 'check.browser'])
    ->name('verification.verify');

    // メール認証されているか確認
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['throttle:6,1', 'check.browser'])
    ->name('verification.send');
});

// ログイン画面からもアクセスできる必要があるため
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store');

Route::get('verify-email', EmailVerificationPromptController::class)
    ->name('verification.notice');

