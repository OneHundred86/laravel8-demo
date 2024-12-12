<?php

namespace App\JwtAuthTest\Controllers;

class GuestController
{
    public function getToken()
    {
        $auth = auth('jwt-guest');
        $token = $auth->attempt([]);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $auth->factory()->getTTL() * 60,
        ]);
    }

    public function getPayload()
    {
        return auth()->payload()->toArray();
    }

    public function me()
    {
        return auth()->user();
    }
}