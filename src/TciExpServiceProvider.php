<?php

namespace surajitbasak109\TciExpApi;

use Illuminate\Support\ServiceProvider;
use surajitbasak109\TciExpApi\TciExpApi;

class TciExpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->alias(TciExpApi::class, 'tciexp');
        $this->mergeConfigFrom(__DIR__.'/../config/tciexp.php', 'tciexp');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/tciexp.php' => config_path('tciexp.php'),
            ], 'config');
        }
    }
}
