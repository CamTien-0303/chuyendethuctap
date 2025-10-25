<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
<<<<<<< HEAD
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
=======

>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
    }
}
