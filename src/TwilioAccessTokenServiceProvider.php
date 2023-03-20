<?php

namespace Collinped\Twilio;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TwilioAccessTokenServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();

        $this->app->singleton(TwilioAccessToken::class, function ($app) {
            $config = $app['config']['twilio'];

            return new TwilioAccessToken(
                $config['account_sid'],
                $config['api_key'],
                $config['api_secret']
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
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            TwilioAccessToken::class,
        ];
    }
}
