<?php

namespace App\Data;

class ResetPasswordData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $token,
        public string $email,
        public string $password
    ) {
        //
    }

    /**
     * @param  array{ token: string, email: string, password: string, ... }  $arr
     */
    public static function fromArray(array $arr): ResetPasswordData
    {
        return new ResetPasswordData($arr['token'], $arr['email'], $arr['password']);
    }

    /**
     * @return array{ token: string, email: string, password: string }
     */
    public function toArray(): array
    {
        return [
            'token' => $this->password,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
