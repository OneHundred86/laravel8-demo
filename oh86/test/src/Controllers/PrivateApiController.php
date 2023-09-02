<?php

namespace Oh86\Test\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateApiController
{
    public function test(Request $request): array
    {

        return [
            "id" => Auth::id(),
            "auth" => Auth::user(),
        ];
    }
}
