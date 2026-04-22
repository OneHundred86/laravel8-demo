<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorsController extends Controller
{
    public function demo1(Request $request)
    {
        return [
            'code' => 0,
            'message' => 'ok',
            'data' => [
                'tag' => 'demo1',
                'token' => $request->session()->token(),
            ],
        ];
    }

    public function demo2(Request $request)
    {
        return [
            'code' => 0,
            'message' => 'ok',
            'data' => [
                'tag' => 'demo2',
                'token' => $request->session()->token(),
            ],
        ];
    }
}
