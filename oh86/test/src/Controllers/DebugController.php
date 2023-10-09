<?php

namespace Oh86\Test\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
}
