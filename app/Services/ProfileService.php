<?php

namespace App\Services;

use App\Data\CreateProfileData;
use App\Models\Profile;
use App\Models\User;

class ProfileService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, CreateProfileData $data): Profile
    {
        return $user->profile()->create([
            'username' => $data->username,
            'display_name' => $data->displayName,
        ]);
    }
}
