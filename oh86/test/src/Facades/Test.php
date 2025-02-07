<?php

namespace Oh86\Test\Facades;

use Illuminate\Support\Facades\Facade;

class Test extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Oh86\Test\TestManager::class;
    }
}