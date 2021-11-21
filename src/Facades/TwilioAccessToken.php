<?php
namespace Collinped\Twilio\Facades;

use Illuminate\Support\Facades\Facade;

class TwilioAccessToken extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Collinped\Twilio\TwilioAccessToken';
    }
}
