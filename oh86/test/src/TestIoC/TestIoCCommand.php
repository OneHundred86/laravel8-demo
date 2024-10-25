<?php

namespace Oh86\Test\TestIoC;

use Illuminate\Cache\RateLimiter;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Oh86\Test\TestIoC\Clazz\MyRateLimiter;

class TestIoCCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oh86:test_ioc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test IoC';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->demo1();
        $this->demo2();
    }

    public function demo1()
    {
        /**
         * 说明：
         * 1. Illuminate\Contracts\Cache\Repository 在 vendor/laravel/framework/src/Illuminate/Foundation/Application.php 被注册别名为'cache.store'；
         * 2. 'cache.store' 在 vendor/laravel/framework/src/Illuminate/Cache/CacheServiceProvider.php 被注册单例解析对象；
         * 3. 所以如果在容器中解析 Illuminate\Contracts\Cache\Repository ，会自动注入上面的单例对象。
         * 4. 所以 app(Illuminate\Contracts\Cache\Repository::class) 可以返回上面的单例对象。
         * 5. Illuminate\Cache\RateLimiter 的构造方法依赖 Illuminate\Contracts\Cache\Repository ，所以 app(Illuminate\Cache\RateLimiter::class) 会在这个参数中自动注入 Illuminate\Contracts\Cache\Repository 对象。
         */
        try {
            $limiter = app(RateLimiter::class);
        } catch (BindingResolutionException $e) {
            $this->error(__METHOD__ . ": " . $e->getMessage());
        }
    }

    public function demo2()
    {
        try {
            $limiter = app(MyRateLimiter::class);
        } catch (BindingResolutionException $e) {
            $this->error(__METHOD__ . ": " . $e->getMessage());
        }
    }
}
