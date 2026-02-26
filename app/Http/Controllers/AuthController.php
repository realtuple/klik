<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

/**
 * Controller handling /auth/ routes
 */
class AuthController extends Controller
{

    /*
        Log in
    */

    /**
     * Shows login page
     * @return \Inertia\Response
     */
    public function loginPage()
    {
        return Inertia::render('Auth/LoginPage');
    }

    /**
     * Authenticates user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ], true)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ]);
    }

    /*
        Registering
    */

    /**
     * Shows login page
     * @return \Inertia\Response
     */
    public function registerPage()
    {
        return Inertia::render('Auth/RegisterPage');
    }

    /**
     * Creates account
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccount(Request $request)
    {
        $data = $request->validate([
            'display_name' => ['required'],
            'username' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'date' => ['required', Rule::date()->beforeOrEqual(today()->subYears(13))]
        ]);

        if (Profile::where('username', $data['username'])->exists()) {
            return back()->withErrors(['username' => __('auth.this_username_is_taken')]);
        }

        if (User::where('email', $data['email'])->exists()) {
            return back()->withErrors(['email' => __('auth.this_email_is_taken'),]);
        }

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->profile()->create([
            'username' => $data['username'],
            'display_name' => $data['display_name'],
        ]);


        event(new Registered($user));

        return redirect()->intended();
    }

    /*
        Logging out
    */

    /**
     * Logouts and invalidates session
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }

    /*
        Email verification
    */

    /**
     * Shows page informing user about email verifications
     * @return \Inertia\Response
     */
    public function notifyAboutEmailVerification()
    {
        return Inertia::render('Auth/NotifyAboutEmailVerification');
    }

    /**
     * Handles email verification
     * @param EmailVerificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/');
    }

    /**
     * Resend verification email
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        Inertia::flash('message', __('auth.verification_link_send'));

        return back();
    }

    /*
        Forgot password
    */

    /**
     * Shows form for sending email with link to reset password form
     * @return \Inertia\Response reset password form
     */
    public function forgotPasswordForm()
    {
        return Inertia::render('Auth/ForgotPasswordForm');
    }

    /**
     * Request that handles sending reset link to user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::ResetLinkSent) {
            Inertia::flash(['email' => __($status)]);
            return back();
        }
        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Shows form for resetting password
     * @param string $token Reset form token
     * @return \Inertia\Response
     */
    public function resetPasswordForm(string $token)
    {
        return Inertia::render('Auth/ResetPasswordForm', ['token' => $token]);
    }

    /**
     * Request for resetting password (finally it does this in this chain of requests)
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });

        if ($status === Password::PasswordReset) {
            return redirect()->route('auth.login');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}
