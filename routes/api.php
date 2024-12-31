<?php

use App\Http\Controllers\GatewayTestController;
use App\Http\Controllers\SanctumAuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Oh86\Test\Controllers\PrivateApiController;
use Oh86\Test\Middlewares\PrivateApiAuthticate;
use Oh86\GW\Auth\Middleware\CheckPrivateRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::any('private/test', [PrivateApiController::class, 'test'])->middleware(PrivateApiAuthticate::class);


// sanctum test
Route::post('sanctum/login', [SanctumAuthController::class, 'login']);
Route::get('sanctum/user', [SanctumAuthController::class, 'getUserInfo'])->middleware('auth:sanctum');

// Auth test
// @doc: https://learnku.com/docs/laravel/8.x/authorization/9382#e63e30
Route::post('post/add', [PostController::class, 'add'])->middleware(['auth:sanctum', 'can:add-post']);


// gw auth test
Route::post('gw/test/request/body', [GatewayTestController::class, 'showRequest'])->middleware([
    CheckPrivateRequest::class . ':admin',
]);
Route::post('gw/test/auth/request/body', [GatewayTestController::class, 'showRequest'])
    ->middleware([
        CheckPrivateRequest::class . ':admin',
        'auth:gw-auth',
    ]);
