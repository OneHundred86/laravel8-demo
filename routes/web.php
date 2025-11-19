<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Oh86\Test\Controllers\DebugController;
use Oh86\Test\Controllers\PostController;
use App\Http\Middleware\Middelware1;
use App\Http\Middleware\Middelware2;
use Illuminate\Support\Facades\Log;
use Oh86\Test\Middlewares\AuthenticateOptional;

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
Route::any('debug/cookie', [DebugController::class, 'setCookie']);

// nginx直接显示：http://my.laravel8.local/README.pdf
// php显示：http://my.laravel8.local/debug/file/view
Route::any("debug/file/view", [DebugController::class, "viewFile"]);

Route::any("post/create", [PostController::class, "create"]);
Route::any("post/update", [PostController::class, "update"]);


Route::any("/middleware/order", function () {
    Log::debug("handler");
    return "ok";
})->middleware([Middelware1::class, Middelware2::class]);

Route::middleware([
        // 'auth:web',
    AuthenticateOptional::class . ':web',
])->post('auth/debug', function () {
    return [
        'user' => Auth::user(),
    ];
});


// 测试相同路由覆盖
// php artisan route:list --path=same/route
// 实测结论：后注册的会覆盖前面的
Route::get('same/route', [DebugController::class, 'echo']);
Route::get('same/route', [DebugController::class, 'log']);

// 测试路由匹配的优先级
// 请求 `/samepath/same/v1/1` 匹配 samepath/same/v1/{path}
// 请求 `/samepath/same/v2/1` 匹配 samepath/same/{path}  而不是 samepath/same/v2/{path}
// 实测结论：按照注册的顺序逐一匹配
Route::get('samepath/same/v1/{path}', [DebugController::class, 'samePath'])->where('path', '.*');
Route::get('samepath/same/v11/{path}', [DebugController::class, 'samePath'])->where('path', '.*');
Route::get('samepath/same/{path}', [DebugController::class, 'samePath'])->where('path', '.*');
Route::get('samepath/same/v2/{path}', [DebugController::class, 'samePath'])->where('path', '.*');
Route::get('samepath/same/v12/{path}', [DebugController::class, 'samePath'])->where('path', '.*');

// cors
/* 测试用例：
fetch("http://a.example.com/api/cors/debug", {
  "headers": {
    "content-type": "application/json",
    "h1": "v1",
  },
  "body": null,
  "method": "GET",
  "mode": "cors",
  "credentials": "include"
});
*/
// options 预检请求
Route::options('cors/debug', function (Request $request) {
    return response('')->withHeaders([
        // 预检请求跨域响应头
        'Access-Control-Allow-Origin' => $request->header('Origin'),    // 必须，根据请求动态设置
        'Access-Control-Allow-Credentials' => 'true',           // 如果实际请求需要携带cookie，这需要这个请求头，且设置为true

        // 'Access-Control-Allow-Methods' => 'GET, POST, PUT',     // 标明实际请求的方法
        'Access-Control-Allow-Methods' => $request->header('Access-Control-Request-Method'),    // 根据请求动态设置 

        // 'Access-Control-Allow-Headers' => 'content-type, h1',   // 标明实际请求需要携带的请求头
        'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers'),   // 根据请求动态设置

        'Access-Control-Max-Age' => '60',                       // 在有效期内，浏览器无需再次发送预检请求。单位秒。
    ]);
})->withoutMiddleware(['web']);
// 实际请求
Route::match(['get', 'post', 'put'], 'cors/debug', function (Request $request) {
    return response([
        'cookies' => $request->header('cookie'),
        'h1' => $request->header('h1'),
        'content-type' => $request->header('content-type'),
        'datas' => $request->all(),
    ])->withHeaders([
                // 实际请求跨域响应头
                'Access-Control-Allow-Origin' => $request->header('Origin'),    // 必须，根据请求动态设置
                'Access-Control-Allow-Credentials' => 'true',   // 如果实际请求需要携带cookie，这需要这个请求头，且设置为true
            ]);
})->withoutMiddleware(['web']);
