<?php

namespace Collinped\Twilio;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TwilioServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        //        $this->registerRoutes();
        $this->registerPublishing();
        $this->registerCommands();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();

        $this->app->singleton(Twilio::class, function ($app) {
            $config = $app['config']['twilio'];

            return new Twilio(
                $config['account_sid'],
                $config['auth_token']
            );
        });
    }

    /**
     * Setup the configuration for Twilio.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/twilio.php',
            'twilio'
        );
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        if (! $this->app->routesAreCached()) {
            if (Twilio::$registersRoutes) {
                Route::group([
                    'prefix' => config('twilio.path'),
                    'namespace' => 'Collinped\Twilio\Http\Controllers',
                    'as' => 'twilio.',
                ], function () {
                    $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
                });
            }
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
                __DIR__.'/../config/twilio.php' => $this->app->configPath('twilio.php'),
            ], 'config');
        }
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Subaccount\TwilioSubaccountCommand::class,

                Console\TwilioBuyPhoneNumberCommand::class,
                Console\TwilioSmsSendCommand::class,
                Console\TwilioAddressCommand::class,
                Console\TwilioVoiceVerifyCommand::class,
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            Twilio::class,
        ];
    }
}
