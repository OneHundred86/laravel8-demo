<?php

namespace Oh86\Test;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Oh86\Test\Policies\PostPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
        // 执行顺序 before -> after -> others(define)
        Gate::before(function (User $user){
            Log::debug("gate::before", func_get_args());

            // return $user->id == 1;
        });
        Gate::before(function (User $user){
            Log::debug("gate::after", func_get_args());

            // return $user->id == 1;
        }); */

        /**
        // 通过callback注册拦截器
        Gate::define("create-post", function (User $user){
            Log::debug("gate::create-post", func_get_args());
            return $user->id == 1;
        }); */
        // 通过类注册拦截器
        Gate::define("create-post", [PostPolicy::class, "create"]);
        Gate::define("update-post", [PostPolicy::class, "update"]);
    }
}
