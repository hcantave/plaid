<?php

namespace Hcantave\Plaid;

use Hcantave\Plaid\Client\Factory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

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

    // public function boot(): void
    public function boot(): void
    {
        // Ensure config_path helper exists (for Lumen or non-Laravel apps)
        if (! function_exists('config_path')) {
            function config_path(?string $path = ''): string
            {
                global $app;

                return $app->basePath().'/config'.($path ? '/'.$path : $path);
            }
        }
        if (! function_exists('base_path')) {
            function base_path(?string $path = ''): string
            {
                global $app;

                return $app->basePath().($path ? '/'.$path : $path);
            }
        }

        $this->publishes([
            //  __DIR__.'/../config/plaid.php' => config_path('plaid.php'),
            __DIR__.'/../config/plaid.php' => function_exists('config_path') ? config_path('plaid.php') : base_path('config/plaid.php'),
        ]);
    }
}
