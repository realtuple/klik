<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
    Auth
*/

Route::get('/auth/login', [AuthController::class, 'loginPage'])
    ->middleware('guest')->name('auth.login');
Route::post('/auth/login', [AuthController::class, 'authenticate'])
    ->middleware('guest')->name('auth.authenticate');
Route::get('/auth/register', [AuthController::class, 'registerPage'])
    ->middleware('guest')->name('auth.register');
Route::post('/auth/register', [AuthController::class, 'createAccount'])
    ->middleware('guest')->name('auth.createAccount');
Route::delete('/auth/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('auth.logout');
Route::get('/auth/verify', [AuthController::class, 'notifyAboutEmailVerification'])
    ->middleware('auth')->name('verification.notice');
Route::get('/auth/verify/{id}/{hash}', [AuthController::class, 'verify'])
    ->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/auth/resend-verification-email', [AuthController::class, 'resendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])->name('auth.resendVerificationEmail');
Route::get('/auth/forgot-password', [AuthController::class, 'forgotPasswordForm'])
    ->middleware('guest')->name('auth.forgotPasswordForm');
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])
    ->middleware('guest')->name('auth.forgotPassword');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])
    ->middleware('guest')->name('password.reset');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])
    ->middleware('guest')->name('auth.resetPassword');

/*
    Homepage
*/

Route::get('/', function () {
    return Inertia::render('Homepage', []);
})->middleware(['auth', 'verified'])->name('homepage');

/*
    Profile system
*/
Route::get('/{profile:username}', [ProfileController::class, 'show'])
    ->name('profile.show');
