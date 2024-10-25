<?php 

namespace Oh86\Test;

use Illuminate\Support\ServiceProvider;
use Oh86\Test\TestIoC\TestIoCCommand;

class TestIoCServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TestIoCCommand::class,
            ]);
        }
    }
}