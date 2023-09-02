<?php

namespace Oh86\Test\Middlewares;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PrivateApiAuthticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set("accept", "application/json");
        Auth::shouldUse("private-api");
        if(!Auth::check()){
             return (new JsonResponse())
                 ->setStatusCode(403)
                 ->setData(["errcode" => 403, "errmessage" => "校验失败"]);
        }

        return $next($request);
    }
}
