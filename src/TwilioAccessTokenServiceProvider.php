<?php

namespace Collinped\Twilio;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class TwilioAccessTokenServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
            $this->commands([
                Console\TwilioAccessTokenCommand::class,
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
        $this->app->singleton('Collinped\Twilio\TwilioAccessToken', function ($app) {
            $config = $app['config']['twilio'];
            return new TwilioAccessToken($config);
        });

        //$this->app->alias('twilio', Twilio::class);
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
//        if (!$this->app->routesAreCached()) {
//            if (Twilio::$registersRoutes) {
//                Route::group([
//                    //'prefix' => config('twilio.path'),
//                    'namespace' => 'Collinped\Twilio\Http\Controllers',
//                    'as' => 'twilio.',
//                ], function () {
//                    $this->loadRoutesFrom(__DIR__ .'/../routes/web.php');
//                });
//            }
//        }
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
            ], 'config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Collinped\Twilio\TwilioAccessToken',
        ];
    }
}
