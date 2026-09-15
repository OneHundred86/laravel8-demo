<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DemoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_env()
    {
        $appName = env('APP_NAME');
        $this->assertEquals('Laravel-ting', $appName);
    }

    public function test_env_abc()
    {
        $abc = env('ABC');
        $this->assertEquals('1', $abc);
    }
}
