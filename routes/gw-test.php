<?php

use Illuminate\Support\Facades\Route;
use Oh86\GW\Auth\Middleware\CheckPrivateRequest;
use Oh86\Test\Controllers\GatewayTestController;
use Oh86\Test\Middlewares\CheckPermissionCode;


// gw auth test
Route::post('gw/test/request/body', [GatewayTestController::class, 'showRequest'])->middleware([
    CheckPrivateRequest::class,
]);
Route::post('gw/test/auth/request/body', [GatewayTestController::class, 'showRequest'])
    ->middleware([
        CheckPrivateRequest::class,
        'auth:gw-auth',
        CheckPermissionCode::class . ':test1',
    ]);


// gw openapi
Route::post('gw/openapi/local', [GatewayTestController::class, 'showRequest'])->middleware([CheckPrivateRequest::class]);
