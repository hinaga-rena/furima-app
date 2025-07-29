<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // ✅ プロフィール画像が未設定なら setup 画面へ遷移
        if (is_null($user->profile_image)) {
            return redirect()->route('profile.setup');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
