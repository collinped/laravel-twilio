<?php

namespace Collinped\TwilioVideo;

use Aloha\Twilio\Commands\TwilioVideoRoomCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class TwilioVideoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->registerLogger();
        $this->registerRoutes();
        //$this->registerResources();
        //$this->registerMigrations();
        $this->registerCommands();
        $this->registerPublishing();
//        Stripe::setAppInfo(
//            'Laravel Cashier',
//            Cashier::VERSION,
//            'https://laravel.com'
//        );
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
    }

    /**
     * Setup the configuration for Cashier.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/twilio-video.php', 'twilio-video'
        );
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if (TwilioVideo::$registersRoutes) {
            Route::group([
                'prefix' => config('twilio-video.path'),
                'namespace' => 'Collinped\TwilioVideo\Http\Controllers',
                'as' => 'twilio-video.',
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            });
        }
    }

    /**
     * Register the package commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->app->singleton('twilio-video.room', TwilioVideoRoomCommand::class);
    }

    /**
     * Register the package migrations.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        if (TwilioVideo::$runsMigrations && $this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/twilio-video.php' => $this->app->configPath('twilio-video.php'),
            ], 'cashier-config');
            $this->publishes([
                __DIR__.'/../database/migrations' => $this->app->databasePath('migrations'),
            ], 'twilio-video-migrations');
        }
    }
}
