<?php

namespace App\Http\Gateway\ProxyMiddlewares;

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Middleware;
use Oh86\GW\ProxyMiddlewares\BaseMiddleware;
use Psr\Http\Message\RequestInterface;

class RequestWithUserInfo extends BaseMiddleware
{
    public function __invoke()
    {

        return Middleware::mapRequest(function (RequestInterface $request) {
            $user = Auth::user();

            return $request->withHeader("GW-Auth-Info", $user->getModel()->toJson());
        });
    }
}
