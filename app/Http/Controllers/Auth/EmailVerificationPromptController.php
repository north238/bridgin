<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        if ($user) {
            return $request->user()->hasVerifiedEmail()
                ? redirect()->intended(RouteServiceProvider::HOME)
                : view('auth.verify-email');
        }

        Log::alert(['message' => 'EmailVerificationPromptControllerでユーザーが存在しないエラーです。']);
        return redirect()->route('login')->with(['error-message' => 'ユーザー登録が正しくできていないようです。再度ログインしてみてください。']);
    }
}
