<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_demo1()
    {
        // 当前基类是`PHPUnit\Framework\TestCase`，只提供 PHPUnit 测试能力。而 [phpunit.xml (line 4)](phpunit.xml:4) 只加载 vendor/autoload.php，并设置了 APP_ENV=testing，不会自动加载对应的环境文件。env('APP_NAME') 读取不到变量，又没传默认值，就返回 null。
        // 如果测试需要加载 Laravel env环境变量，把基类导入改为：Tests\TestCase
        // Unit测试类默认继承`PHPUnit\Framework\TestCase`。 `php artisan make:test` 生成的 Unit 测试类默认继承 `PHPUnit\Framework\TestCase`，只提供 PHPUnit 测试能力。不会自动加载 Laravel 环境变量。
        // Feature测试类默认继承`Tests\TestCase`
        $appName = env('APP_NAME');
        $this->assertEquals('Laravel', $appName);
    }
}
/**
 * 查看测试命令文档：
 * vendor/bin/phpunit --help
 * 
 * 运行测试用例：
 * # 运行所有测试用例
 * vendor/bin/phpunit
 * 
 * # 运行指定测试用例文件的所有测试用例
 * vendor/bin/phpunit ./tests/Feature/DemoTest.php
 * 
 * # 运行指定测试用例文件的指定测试方法
 * vendor/bin/phpunit ./tests/Feature/DemoTest.php --filter test_env_abc
 */
