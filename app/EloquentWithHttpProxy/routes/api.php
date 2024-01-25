<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

Route::post("/db/http/proxy", function (Request $request){
    $connection = DB::connection($request->connection);
    Log::debug("httppproxy", $request->all());

    $method = $request->input("method");
    $arguments = json_decode(base64_decode($request->input("arguments")));

    $result = $connection->{$method}(...$arguments);

    return serialize($result);
});
