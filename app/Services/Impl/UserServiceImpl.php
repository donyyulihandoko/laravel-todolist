<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    // data users
    private array $users = [
        'user1' => 'rahasia'
    ];

    public function login(string $user, string $password): bool
    {
        // validasi user
        if (!isset($this->users[$user])) {
            return false;
        }

        // validasi password
        $correctPassword = $this->users[$user];
        return $password == $correctPassword;
    }
}
