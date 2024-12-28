<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class SanctumAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'device' => 'required',
        ]);

        $user = User::query()->where('email', $request->email)->first();

        if (!$user) {
            abort(404, "user not found");
        }

        return $user->createToken($request->device)->plainTextToken;
    }

    public function getUserInfo(Request $request)
    {
        // return $request->user();
        return Auth::user();
    }
}
