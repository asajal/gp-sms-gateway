<?php

namespace arifsajal\GpSmsGateway\Providers;

use arifsajal\GpSmsGateway\Services\GpSmsGateway;
use Illuminate\Support\ServiceProvider;

class GPServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gpsmsgateway', function ($app) {
            return new GpSmsGateway();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['gpsmsgateway'];
    }
}
