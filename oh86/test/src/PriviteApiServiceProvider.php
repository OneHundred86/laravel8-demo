<?php

namespace Oh86\Test;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Oh86\Test\AuthEntity\PrivateApi;

class PriviteApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        Auth::viaRequest("private-api-driver", function (Request $request){
            $app = $request->input("app");
            $time = $request->input("time");
            $token = $request->input("token");

            Log::debug("PriviteApiServiceProvider", compact("app", "time", "token"));

            if($app != "test"){
                return null;
            }

            // return ["app" => $app];
            return new PrivateApi($app);
        });
    }
}
