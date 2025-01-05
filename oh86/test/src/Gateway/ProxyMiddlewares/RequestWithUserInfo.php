<?php

namespace Oh86\Test\Gateway\ProxyMiddlewares;

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Middleware;
use Oh86\GW\ProxyMiddlewares\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;

class RequestWithUserInfo extends AbstractMiddleware
{
    public function __invoke(...$args)
    {
        return Middleware::mapRequest(function (RequestInterface $request) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // load permission codes
            $user->permission_codes = ['test1', 'test2'];

            return $request->withHeader("GW-Auth-Info", $user->getModel()->toJson());
        });
    }
}
