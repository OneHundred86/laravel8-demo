<?php

namespace Oh86\Test\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GatewayTestController
{
    public function showRequest(Request $request)
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

        $user = Auth::user();

        return compact("all", "allFiles0", "allFiles", "headers", "user");
    }
}
