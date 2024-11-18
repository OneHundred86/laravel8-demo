<?php

use Illuminate\Support\Facades\Route;
use Oh86\Test\Controllers\DebugController;
use Oh86\Test\Controllers\PostController;
use App\Http\Middleware\Middelware1;
use App\Http\Middleware\Middelware2;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any("debug/session", [DebugController::class, "session"]);
Route::any("debug/login", [DebugController::class, "login"]);
Route::any("debug/request/body", [DebugController::class, "requestBody"])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
Route::any("debug/wait", [DebugController::class, "wait"]);
Route::any("debug/params/hash", [DebugController::class, "calcHash"])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
Route::any("debug/redirect", [DebugController::class, "redirect"]);
Route::any("debug/echo", [DebugController::class, "echo"]);
Route::any("debug/log", [DebugController::class, "log"]);

// nginx直接显示：http://my.laravel8.local/README.pdf
// php显示：http://my.laravel8.local/debug/file/view
Route::any("debug/file/view", [DebugController::class, "viewFile"]);

Route::any("post/create", [PostController::class, "create"]);
Route::any("post/update", [PostController::class, "update"]);


Route::any("/middleware/order", function () {
    Log::debug("handler");
    return "ok";
})->middleware([Middelware1::class, Middelware2::class]);
