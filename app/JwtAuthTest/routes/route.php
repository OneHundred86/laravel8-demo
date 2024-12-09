<?php

use App\JwtAuthTest\Controllers\AuthController;


Route::post('jwt/test/login', [AuthController::class, 'login']);
Route::group([
    'middleware' => ['auth:jwt-api'],
    'prefix' => 'jwt/test',
], function ($router) {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('payload', [AuthController::class, 'getPayload']);
});