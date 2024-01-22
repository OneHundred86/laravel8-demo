<?php

namespace App\EloquentWithHttpProxy;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class EloquentWithHttpProxyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->loadRoutes();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // Add database driver.
        $this->app->resolving('db', function (DatabaseManager $db) {
            $db->extend('httpproxy', function ($config, $name) use($db) {
                $con = new Connection($config);
                return $con;
            });
        });


    }

    protected function loadRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
    }
}
