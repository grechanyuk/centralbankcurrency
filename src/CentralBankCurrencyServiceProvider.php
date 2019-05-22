<?php

namespace Grechanyuk\CentralBankCurrency;

use Grechanyuk\CentralBankCurrency\Commands\CentralBankSyncCommand;
use Illuminate\Support\ServiceProvider;

class CentralBankCurrencyServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'grechanyuk');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'grechanyuk');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
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
        $this->mergeConfigFrom(__DIR__.'/../config/centralbankcurrency.php', 'centralbankcurrency');

        // Register the service the package provides.
        $this->app->singleton('centralbankcurrency', function ($app) {
            return new CentralBankCurrency;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['centralbankcurrency'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/centralbankcurrency.php' => config_path('centralbankcurrency.php'),
        ], 'centralbankcurrency.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/grechanyuk'),
        ], 'centralbankcurrency.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/grechanyuk'),
        ], 'centralbankcurrency.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/grechanyuk'),
        ], 'centralbankcurrency.views');*/

        // Registering package commands.
        $this->commands([
            CentralBankSyncCommand::class
        ]);
    }
}
