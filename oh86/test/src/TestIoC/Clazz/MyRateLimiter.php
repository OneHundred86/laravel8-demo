<?php

namespace Oh86\Test\TestIoC\Clazz;

use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Cache\Repository as Cache;


class MyRateLimiter
{
    /**
     * 对比 Illuminate\Cache\RateLimiter 进行依赖注入
     * 
     * @param  \Illuminate\Contracts\Cache\Repository  $cache
     * @param  int  $a  该参数在容器中解析不了，所以不能使用容器注入 MyRateLimiter 的类实例
     */
    public function __construct(Cache $cache, int $a) {}
}
