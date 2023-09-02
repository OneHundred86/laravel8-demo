<?php

use Illuminate\Support\Facades\Route;
use Oh86\Test\Controllers\DebugController;
use Oh86\Test\Controllers\PostController;

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

Route::any("post/create", [PostController::class, "create"]);
Route::any("post/update", [PostController::class, "update"]);

