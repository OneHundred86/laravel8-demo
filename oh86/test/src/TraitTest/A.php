<?php

namespace Oh86\Test\TraitTest;

use Oh86\Test\Traits\CachedAttributesTrait;

class A
{
    use CachedAttributesTrait;

    public function test()
    {
        $this->setCachedAttribute("foo", "bar");
        echo $this->getCachedAttribute("foo"); // 输出 "bar"
        echo "\n";
    }
}
