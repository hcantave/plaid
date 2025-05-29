<?php

namespace CaashApp\Plaid;

use CaashApp\Plaid\Client\Factory;
use Illuminate\Support\ServiceProvider;

class PlaidServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('plaid', function ($app): Factory {
            return new Factory(
                config('plaid.client'),
                config('plaid.secret'),
                config('plaid.env'),
                config('app.name'),
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/plaid.php' => config_path('plaid.php'),
        ]);
    }
}
