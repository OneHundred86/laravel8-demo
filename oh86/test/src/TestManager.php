<?php

namespace Oh86\Test;

use Illuminate\Support\Manager;

class TestManager extends Manager
{
    public function getDefaultDriver()
    {
        return 'test';
    }
}