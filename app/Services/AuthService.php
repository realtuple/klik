<?php

namespace App\Services;

use App\Data\CreateProfileData;
use App\Data\CreateUserData;
use App\Data\ResetPasswordData;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Password;
use Str;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ProfileService $profileService)
    {
        //
    }

    public function create(CreateUserData $data): User
    {
        $user = User::create([
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        $profileData = new CreateProfileData($data->displayName, $data->username);
        $this->profileService->create($user, $profileData);

        event(new Registered($user));

        return $user;
    }

    // $request->only('email', 'password', 'password_confirmation', 'token')
    public function resetPassword(ResetPasswordData $data): mixed
    {
        return Password::reset($data->toArray(), function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });
    }
}
