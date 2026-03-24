<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function show(Profile $profile): Response
    {
        return Inertia::render('Profile/Show', ['shown_profile' => $profile]);
    }
}
