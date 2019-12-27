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
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/twilio-video.php' => $this->app->configPath('twilio-video.php'),
            ], 'twilio-video-config');
        }
    }
}
