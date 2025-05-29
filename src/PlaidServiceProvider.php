<?php

namespace Hcantave\Plaid;

use Hcantave\Plaid\Client\Factory;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Config;
use function config_path;

class PlaidServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('plaid', function ($app): Factory {
            return new Factory(
                Config::get('plaid.client'),
                Config::get('plaid.secret'),
                Config::get('plaid.env'),
                Config::get('app.name'),
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
