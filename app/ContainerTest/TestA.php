<?php

namespace App\ContainerTest;

class TestA implements TestInterface
{
    protected string $str;

    /**
     * @param string $str
     */
    public function __construct(string $str)
    {
        $this->str = $str;
    }


    public function get()
    {
        return __CLASS__ . ":" . $this->str;
    }
}
