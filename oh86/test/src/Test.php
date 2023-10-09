<?php

namespace Oh86\Test;

use SebastianBergmann\CodeCoverage\Report\PHP;

class Test
{
    private string $str;

    /**
     * @param string $str
     */
    public function __construct(string $str)
    {
        $this->str = $str;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        echo __METHOD__ . PHP_EOL;
        return $this->str;
    }
}
