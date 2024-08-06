<?php

namespace App\Security;

class UserDataPasswordHasher
{
    public function setPassword(string $password): string
    {
        return md5($password);
    }
}