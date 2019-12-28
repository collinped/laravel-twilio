<?php


namespace Collinped\Twilio;

use Twilio\Rest\Client as TwilioService;

class Twilio
{
    /**
     * @var string
     */
    protected $accountSid;

    /**
     * @var string
     */
    protected $authToken;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * @var bool
     */
    protected $sslVerify;

    /**
     * @var \Twilio\Rest\Client
     */
    protected $twilio;

    public function __construct($accountSid, $authToken, $sslVerify, $apiKey, $apiSecret)
    {
        $this->accountSid = $accountSid;
        $this->authToken = $authToken;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->sslVerify = $sslVerify;
    }

    /**
     * Indicates if Twilio Video routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

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
        return $this->twilio = new TwilioService($this->accountSid, $this->authToken);
    }
}
