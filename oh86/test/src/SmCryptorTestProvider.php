<?php

namespace Oh86\Test;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Oh86\SmCryptor\Facades\Cryptor as SmCryptor;
use Oh86\Test\SmCryptorTest\TestCryptor;

class SmCryptorTestProvider extends ServiceProvider
{
    public function register()
    {
        SmCryptor::extend("test", function (Application $app, array $config) {
            return new TestCryptor($config);
        });
    }
}