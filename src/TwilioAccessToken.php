<?php


namespace Collinped\Twilio;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Jwt\AccessToken;

class TwilioAccessToken
{
    protected $identity = null;
    protected $ttl = 3600;

    /**
     * @var \Twilio\Jwt\AccessToken
     */
    private $accessToken;

    public function __construct($config)
    {
        try {
            return $this->accessToken = new AccessToken(
                $config['account_sid'],
                $config['api_key'],
                $config['api_secret'],
                $this->ttl,
                $this->identity
            );
        } catch (ConfigurationException $e) {
            dd($e);
        }
    }

    public function setIdentity($identity) {
        $this->identity = $identity;

        return $this;
    }
    public function setTTL($ttl) {
        $this->ttl = $ttl;

        return $this;
    }

    public function sdk()
    {
        return $this->accessToken;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function getToken()
    {
        return $this->accessToken->toJWT();
    }
}
