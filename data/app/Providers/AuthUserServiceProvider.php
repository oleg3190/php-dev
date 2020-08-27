<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthUserServiceProvider  extends ServiceProvider
{


    public function register()
    {
        $this->app->bind(
            'App\Interfaces\AuthInterface',
            'App\services\AuthService'
        );
    }

    public function boot()
    {

    }
}
