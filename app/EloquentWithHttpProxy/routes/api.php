<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

Route::post("/db/http/proxy", function (Request $request){
    $connection = DB::connection($request->connection);
    $builder = $connection->query();
    Log::debug("httppproxy", $request->all());

    $result = null;
    foreach ($request->callArr as $call){
        $result = $builder->{$call["method"]}(...$call["arguments"]);
    }

    return serialize($result);
});
