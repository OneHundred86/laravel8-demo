<?php

namespace App\JwtAuthTest;

class JwtAuthTestServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/route.php');
    }
}