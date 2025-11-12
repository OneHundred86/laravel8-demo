<?php

namespace Oh86\Test\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class DebugController
{
    public function session(Request $request)
    {
        return [
            "id" => Session::getId(),
            "session" => Session::all(),
        ];
    }

    public function login(Request $request)
    {
        $id = $request->input("id");
        /** @var User $user */
        $user = User::query()->find($id);
        Auth::login($user);

        return $user;
    }

    public function requestBody(Request $request)
    {
        // 所有参数，包括文件的key
        $all = $request->all();

        // 所有文件
        $allFiles0 = $request->allFiles();

        // 所有header
        $headers = $request->headers->all();

        $allFiles = [];
        /**
         * @var string $key
         * @var \Illuminate\Http\UploadedFile $file
         */
        foreach ($allFiles0 as $key => $file) {
            $allFiles[$key] = $file->getClientOriginalName();
        }

        return compact("all", "allFiles0", "allFiles", "headers");
    }

    public function wait(Request $request)
    {
        sleep($request->seconds);

        return $request->all();
    }

    public function calcHash(Request $request)
    {
        $all = $request->all();
        ksort($all);

        $bufArr = [];
        foreach ($all as $key => $value) {
            // 文件，取md5值
            if ($value instanceof UploadedFile) {
                $value = md5_file($value->getPathname());
            }

            $bufArr[] = sprintf("%s=%s", $key, $value);
        }
        $buf = implode("&", $bufArr);

        return [
            "all" => $all,
            "hash" => md5($buf),
        ];
    }

    public function redirect(Request $request)
    {
        // 以当前路径为相对路径
        // header("Location: ./test?a=1#abc");

        // 以根目录为相对路径
        URL::forceRootUrl(config("app.url"));
        // return redirect("test?a=1#abc");
        return new RedirectResponse("/test?a=1#abc");
    }

    public function viewFile()
    {
        $path = public_path("README.pdf");
        return response(file_get_contents($path))->header("Content-Type", "application/pdf");
    }

    public function echo(Request $request)
    {
        return [
            "headers" => $request->headers->all(),
            "params" => $request->all(),
        ];
    }

    public function log(Request $request)
    {
        Log::debug(__METHOD__, $request->all());

        return "ok";
    }

    public function setCookie(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'value' => 'required|string',
        ]);

        // 使用浏览器的 fetch，模拟ajax请求，返回的cookie也会设置进浏览器里面。
        return response([
            'code' => 0,
            'message' => 'ok',
            // 返回旧的cookie
            'data' => $request->cookie(),
        ])->withCookie(
                // 设置新的cookie
                cookie($request->name, $request->value)
            );
    }
}
