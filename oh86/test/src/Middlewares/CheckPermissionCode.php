<?php

namespace Oh86\Test\Middlewares;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Oh86\Http\Exceptions\ErrorCodeException;
use Oh86\Test\Access\User;

class CheckPermissionCode
{
    /**
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, $next, $permissionCode)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        if (!$user->hasPermissionCode($permissionCode)) {
            throw new ErrorCodeException(403, "permission error", null, 403);
        }

        return $next($request);
    }
}