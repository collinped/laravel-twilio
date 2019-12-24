<?php


namespace Collinped\TwilioVideo;

use Twilio\Rest\Client;

class TwilioVideo
{
    protected $accountSid;
    protected $authToken;
    protected $apiKey;
    protected $apiSecret;

    /**
     * @var \Twilio\Rest\Client
     */
    protected $twilio;

    public function __construct($accountSid, $authToken, $apiKey, $apiSecret)
    {
        $this->accountSid = $accountSid;
        $this->authToken = $authToken;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Indicates if Twilio Video migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * Indicates if Twilio Video routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * Configure Twilio Video to not register its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;
        return new static;
    }

    /**
     * Configure Twilio Video to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes()
    {
        static::$registersRoutes = false;
        return new static;
    }

    /**
     * @return \Twilio\Rest\Client
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function twilio()
    {
        if ($this->twilio) {
            return $this->twilio;
        }
        return $this->twilio = new Client($this->accountSid, $this->authToken);
    }
}
