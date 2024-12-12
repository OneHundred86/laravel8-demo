<?php

namespace App\JwtAuthTest\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use JsonSerializable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Guest implements Authenticatable, JWTSubject, JsonSerializable
{
    public function getAuthIdentifierName()
    {
        return '';
    }

    public function getAuthIdentifier()
    {
        return -1;
    }

    public function getAuthPassword()
    {
        return '';
    }

    public function getRememberToken()
    {
        return '';
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
        return '';
    }


    public function getJWTIdentifier()
    {
        return $this->getAuthIdentifier();
    }

    public function getJWTCustomClaims()
    {
        return [
            'iss' => config('app.name'),
            'type' => 'guest',
        ];
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getAuthIdentifier(),
            'type' => 'guest',
        ];
    }
}