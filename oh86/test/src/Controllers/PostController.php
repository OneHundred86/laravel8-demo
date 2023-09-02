<?php

namespace Oh86\Test\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController
{
    public function create(Request $request)
    {
        if(!Gate::check("create-post")){
            abort(403);
        }

        return "ok";
    }

    public function update(Request $request)
    {
        if(!Gate::check("update-post", $request)){
            abort(403);
        }

        return "ok";
    }
}
