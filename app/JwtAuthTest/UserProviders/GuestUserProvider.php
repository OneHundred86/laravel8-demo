<?php

namespace App\JwtAuthTest\UserProviders;

use App\JwtAuthTest\Models\Guest;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class GuestUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return new Guest();
    }

    public function retrieveByCredentials(array $credentials)
    {
        return new Guest();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return true;
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken($user, $token)
    {
        //
    }
}