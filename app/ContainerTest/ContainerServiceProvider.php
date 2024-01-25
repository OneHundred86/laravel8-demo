<?php

namespace App\ContainerTest;

use App\ContainerTest\Commands\TestCommand;
use App\ContainerTest\Controllers\TestController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ContainerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TestInterface::class, function (){
            return new TestA("singleton");
        });

        // 只能在构造方法自动注入才会生效
        $this->app->when(TestController::class)
            ->needs(TestInterface::class)
            ->give(function () {
                return new TestA("when TestController");
            });

        $this->app->when(TestCommand::class)
            ->needs(TestInterface::class)
            ->give(function () {
                return new TestA("when TestCommand");
            });

        //
        $this->app->singleton(TestB::class, function ($app) {
            return new TestB("singleton");
        });
        $this->app->bind(TestC::class, function ($app) {
            return new TestC("bind");
        });

        // 容器事件，可以注册多次
        // 服务容器每次解析对象会触发一个事件，你可以使用 resolving 方法监听这个事件
        $this->app->resolving(TestB::class, function (TestB $object, Application $app){
            var_dump("resolving TestB：1", $object->get());
        });
        $this->app->resolving(TestB::class, function (TestB $object, Application $app){
            var_dump("resolving TestB：2", $object->get());
        });

        $this->app->resolving(TestC::class, function (TestC $object, Application $app){
            var_dump("resolving TestC", $object->get());
        });
        /**
         * test:
         *      app(\App\ContainerTest\TestB::class)
         *      app(\App\ContainerTest\TestC::class)
         */
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TestCommand::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__."/routes/api.php");
    }
}
