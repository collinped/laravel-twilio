<?php

namespace Collinped\Twilio;

use Collinped\Twilio\Commands\TwilioVideoRoomCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TwilioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerCommands();
        $this->registerPublishing();
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
     * Setup the configuration for Twilio.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/twilio.php', 'twilio'
        );
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if (Twilio::$registersRoutes) {
            Route::group([
                'prefix' => config('twilio.path'),
                'namespace' => 'Collinped\Twilio\Http\Controllers',
                'as' => 'twilio.',
            ], function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
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
        $this->app->singleton('twilio.video.room', TwilioVideoRoomCommand::class);
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
                __DIR__ . '/../config/twilio.php' => $this->app->configPath('twilio.php'),
            ], 'twilio-config');
        }
    }
}
