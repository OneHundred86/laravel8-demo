<?php

namespace Oh86\Test\Policies;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostPolicy
{
    protected function isAdmin(User $user): bool
    {
        return $user->id === 1;
    }


    public function create(User $user): bool
    {
        Log::debug(__METHOD__, func_get_args());

        return $this->isAdmin($user);
    }

    public function update(User $user, Request $request)
    {
        Log::debug(__METHOD__, func_get_args());

        return $this->isAdmin($user);
    }
}
