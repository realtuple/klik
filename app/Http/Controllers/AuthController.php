<?php

namespace App\Http\Controllers;

use App\Data\CreateUserData;
use App\Data\ResetPasswordData;
use App\Http\Requests\AuthenticateRequest;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Inertia\Inertia;

/**
 * Controller handling /auth/ routes
 */
class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    /*
        Log in
    */

    /**
     * Shows login page
     *
     * @return \Inertia\Response
     */
    public function loginPage()
    {
        return Inertia::render('Auth/LoginPage');
    }

    /**
     * Authenticates user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(AuthenticateRequest $request)
    {
        if (
            Auth::attempt($request->validated(), true)
        ) {
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
     *
     * @return \Inertia\Response
     */
    public function registerPage()
    {
        return Inertia::render('Auth/RegisterPage');
    }

    /**
     * Creates account
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccount(CreateUserRequest $request)
    {
        $plainData = $request->validated();
        $userData = new CreateUserData($plainData['display_name'], $plainData['username'], $plainData['email'], $plainData['password']);
        $this->authService->create($userData);

        return redirect()->intended();
    }

    /*
        Logging out
    */

    /**
     * Logouts and invalidates session
     *
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
     *
     * @return \Inertia\Response
     */
    public function notifyAboutEmailVerification()
    {
        return Inertia::render('Auth/NotifyAboutEmailVerification');
    }

    /**
     * Handles email verification
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/');
    }

    /**
     * Resend verification email
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->user()?->sendEmailVerificationNotification();

        Inertia::flash('message', __('auth.verification_link_send'));

        return back();
    }

    /*
        Forgot password
    */

    /**
     * Shows form for sending email with link to reset password form
     *
     * @return \Inertia\Response reset password form
     */
    public function forgotPasswordForm()
    {
        return Inertia::render('Auth/ForgotPasswordForm');
    }

    /**
     * Request that handles sending reset link to user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::ResetLinkSent) {
            Inertia::flash(['email' => __($status)]);

            return back();
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Shows form for resetting password
     *
     * @param  string  $token  Reset form token
     * @return \Inertia\Response
     */
    public function resetPasswordForm(string $token)
    {
        return Inertia::render('Auth/ResetPasswordForm', ['token' => $token]);
    }

    /**
     * Request for resetting password (finally it does this in this chain of requests)
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = $this->authService->resetPassword(ResetPasswordData::fromArray($request->validated()->only(['email', 'token', 'password'])));

        if ($status === Password::PasswordReset) {
            return redirect()->route('auth.login');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}
