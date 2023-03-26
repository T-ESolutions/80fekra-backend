<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //user
        $this->app->bind(
            'App\Http\Controllers\Interfaces\V1\User\AuthRepositoryInterface',
            'App\Http\Controllers\Eloquent\V1\User\AuthRepository'
        );
        $this->app->bind(
            'App\Http\Controllers\Interfaces\V1\User\HomeRepositoryInterface',
            'App\Http\Controllers\Eloquent\V1\User\HomeRepository'
        );

        $this->app->bind(
            'App\Http\Controllers\Interfaces\V1\User\UserRepositoryInterface',
            'App\Http\Controllers\Eloquent\V1\User\UserRepository'
        );


    }
}
