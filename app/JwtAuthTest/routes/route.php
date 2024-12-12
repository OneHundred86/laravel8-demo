<?php

use App\JwtAuthTest\Controllers\AuthController;
use App\JwtAuthTest\Controllers\GuestController;


Route::group([
    'prefix' => 'jwt/guest',
    'middleware' => ['auth:jwt-auth,jwt-guest'],
], function ($router) {
    Route::get('token', [GuestController::class, 'getToken'])->withoutMiddleware('auth:jwt-auth,jwt-guest');
    Route::get('payload', [GuestController::class, 'getPayload']);
    Route::get('me', [GuestController::class, 'me']);
});


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