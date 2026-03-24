<?php

namespace App\Data;

class CreateProfileData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $displayName,
        public string $username,
    ) {
        //
    }
}
