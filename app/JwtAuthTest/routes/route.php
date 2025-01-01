<?php

use App\JwtAuthTest\Controllers\AuthController;
use App\JwtAuthTest\Controllers\GuestController;


Route::post('jwt/test/login', [AuthController::class, 'login']);
Route::group([
    'middleware' => ['auth:jwt-auth'],
    'prefix' => 'jwt/test',
], function ($router) {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('payload', [AuthController::class, 'getPayload']);
});