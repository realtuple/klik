<?php

namespace App\Data;

class CreateUserData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $displayName,
        public string $username,
        public string $email,
        public string $password
    ) {
        //
    }
}
