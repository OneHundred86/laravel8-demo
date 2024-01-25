<?php
use Illuminate\Support\Facades\Route;
use App\ContainerTest\Controllers\TestController;

Route::any("container/test", [TestController::class, "test"]);
