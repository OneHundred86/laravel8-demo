<?php

namespace App\Http\Gateway\ProxyMiddlewares;

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Middleware;
use Oh86\GW\ProxyMiddlewares\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;

class RequestWithUserInfo extends AbstractMiddleware
{
    public function __invoke(...$args)
    {
        return Middleware::mapRequest(function (RequestInterface $request) {
            $user = Auth::user();

            return $request->withHeader("GW-Auth-Info", $user->getModel()->toJson());
        });
    }
}
