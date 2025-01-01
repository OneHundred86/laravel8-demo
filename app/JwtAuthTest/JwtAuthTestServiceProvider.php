<?php

namespace App\JwtAuthTest;

use App\JwtAuthTest\UserProviders\GuestUserProvider;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTGuard;

class JwtAuthTestServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/route.php');
    }

    public function register()
    {
    }
}