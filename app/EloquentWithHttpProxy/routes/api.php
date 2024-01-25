<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

Route::post("/http/db", function (Request $request){
    Log::debug("httppproxy-db", $request->all());

    $connection = DB::connection($request->connection);
    $objType = $request->objType;
    $method = $request->input("method");
    $arguments = json_decode(base64_decode($request->input("arguments")), true);
    $options = $request->options;

    if ($objType == "QueryBuilder"){
        $builder = $connection->query();
        foreach ($options as $key => $value) {
            $builder->{$key} = $value;
        }

        $result = $builder->{$method}(...$arguments);
    }else{ // Connection
        $result = $connection->{$method}(...$arguments);
    }

    return serialize($result);
});
