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
            'App\Http\Controllers\Interfaces\V1\AuthRepositoryInterface',
            'App\Http\Controllers\Eloquent\V1\AuthRepository'
        );
        $this->app->bind(
            'App\Http\Controllers\Interfaces\V1\HomeRepositoryInterface',
            'App\Http\Controllers\Eloquent\V1\HomeRepository'
        );

        $this->app->bind(
            'App\Http\Controllers\Interfaces\V1\HelpersRepositoryInterface',
            'App\Http\Controllers\Eloquent\V1\HelpersRepository'
        );

        $this->app->bind(
            'App\Http\Controllers\Interfaces\V1\UserRepositoryInterface',
            'App\Http\Controllers\Eloquent\V1\UserRepository'
        );


    }
}
