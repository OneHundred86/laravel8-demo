<?php

namespace Oh86\Test\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $user= User::query()->find($id);
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
        foreach ($allFiles0 as $key => $file){
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
        foreach($all as $key => $value){
            // 文件，取md5值
            if($value instanceof UploadedFile){
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
        // header("Location: ./test");

        // 以根目录为相对路径
        return redirect("test");
    }
}
