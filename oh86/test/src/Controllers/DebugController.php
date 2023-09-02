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
}
