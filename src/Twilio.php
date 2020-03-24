<?php


namespace Collinped\Twilio;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

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
     * @var Client
     */
    protected $client;

    /**
     * @var \Twilio\Rest\Client
     */
    protected $twilio;

    public function __construct($config)
    {
//        $this->accountSid = $accountSid;
//        $this->authToken = $authToken;
//        $this->apiKey = $apiKey;
//        $this->apiSecret = $apiSecret;

        try {
            $this->client = new Client($config['account_sid'], $config['auth_token']);
        } catch (ConfigurationException $e) {
            dd($e);
        }
    }

    /**
     * Indicates if Twilio routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * Configure Twilio to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes()
    {
        static::$registersRoutes = false;
        return new static;
    }

    public function sdk()
    {
        return $this->client;
    }
}
