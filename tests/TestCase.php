<?php

namespace Collinped\Twilio\Tests;

use Collinped\Twilio\TwilioServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    //    protected bool $loadEnvironmentVariables = true;

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            TwilioServiceProvider::class,
        ];
    }
}
