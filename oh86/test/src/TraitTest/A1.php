<?php

namespace Oh86\Test\TraitTest;

use Oh86\Test\Traits\CachedAttributesTrait;

class A1 extends A
{
    use CachedAttributesTrait; // 再次使用同一个trait，会覆盖父类中trait的属性和方法

    public function test()
    {
        A::test(); // 调用父类的方法，输出 "bar"

        $this->setCachedAttribute("foo1", "bar1");
        echo $this->getCachedAttribute("foo1"); // 输出 "bar1"
        echo "\n";
    }
}
