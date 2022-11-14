<?php

namespace Collinped\Twilio\Facades;

use Illuminate\Support\Facades\Facade;

class Twilio extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Collinped\Twilio\Twilio';
    }
}
