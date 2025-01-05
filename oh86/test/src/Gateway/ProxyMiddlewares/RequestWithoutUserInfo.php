<?php

namespace Oh86\Test\Gateway\ProxyMiddlewares;

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Middleware;
use Oh86\GW\ProxyMiddlewares\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;

/**
 * 用不上，因为可以设置请求头白名单，去掉这些会“注入攻击”的请求头
 */
class RequestWithoutUserInfo extends AbstractMiddleware
{
    public function __invoke(...$args)
    {
        return Middleware::mapRequest(function (RequestInterface $request) {
            $user = Auth::user();

            // permission codes
            // todo

            return $request->withoutHeader("GW-Auth-Info");
        });
    }
}
