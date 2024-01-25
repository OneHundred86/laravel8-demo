<?php

namespace App\ContainerTest\Controllers;

use App\ContainerTest\TestInterface;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * @var TestInterface
     */
    protected $test;
    public function __construct(TestInterface $test)
    {
        $this->test = $test;
    }

    public function test(TestInterface $test)
    {
        return [
            "t1" => $this->test->get(),  // when TestController
            "t2" => $test->get(), // singleton
        ];
    }
}
