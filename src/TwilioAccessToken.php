<?php

namespace Collinped\Twilio;

use Collinped\Twilio\Exception\InvalidArgumentException;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\Grants\VideoGrant;

class TwilioAccessToken
{
    protected ?string $accountSid = null;

    protected ?string $apiKey = null;

    protected ?string $apiSecret = null;

    protected int $ttl = 3600;

    protected ?string $identity = null;

    protected ?string $region = null;

    /**
     * @var AccessToken
     */
    private AccessToken $accessToken;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $accountSid = null,
        ?string $apiKey = null,
        ?string  $apiSecret = null,
        ?int $ttl = 3600,
        ?string $identity = null,
        ?string $region = null
    ) {
        if (! is_null($accountSid)) {
            $this->setAccountSid($accountSid);
        }

        if (! is_null($apiKey)) {
            $this->setApiKey($apiKey);
        }

        if (! is_null($apiSecret)) {
            $this->setApiSecret($apiSecret);
        }

        if (! is_null($ttl)) {
            $this->setTTL($ttl);
        }

        if (! is_null($identity)) {
            $this->setIdentity($identity);
        }

        if (! is_null($region)) {
            $this->setRegion($region);
        }
    }

    /**
     * Set the API key.
     *
     * @param $accountSid
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setAccountSid($accountSid): TwilioAccessToken
    {
        if (! is_string($accountSid) || empty($accountSid)) {
            throw new InvalidArgumentException('A valid Account SID is required.');
        }

        $this->accountSid = $accountSid;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setApiKey($apiKey): TwilioAccessToken
    {
        if (! is_string($apiKey) || empty($apiKey)) {
            throw new InvalidArgumentException('A valid API Key is required.');
        }

        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setApiSecret($apiSecret): TwilioAccessToken
    {
        if (! is_string($apiSecret) || empty($apiSecret)) {
            throw new InvalidArgumentException('A valid API Secret is required.');
        }

        $this->apiSecret = $apiSecret;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setRegion($region): TwilioAccessToken
    {
        if (! is_string($region) || empty($region)) {
            throw new InvalidArgumentException('A valid region is required.');
        }

        $this->region = $region;

        return $this;
    }

    public function setIdentity($identity = null): TwilioAccessToken
    {
        $this->identity = (is_null($identity) ? uniqid() : $identity);

        return $this;
    }

    public function setTTL($ttl): TwilioAccessToken
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function sdk(): AccessToken
    {
        return $this->getTwilioAccessToken();
    }

    public function getAccessToken(): AccessToken
    {
        return $this->getTwilioAccessToken();
    }

    public function getToken(): string
    {
        return $this->getTwilioAccessToken()->toJWT();
    }

    public function toJWT(): string
    {
        return $this->getToken();
    }

    public function forVideo($roomName = null): static
    {
        $grant = new VideoGrant();

        $grant->setRoom($roomName);

        $this->getTwilioAccessToken()->addGrant($grant);

        return $this;
    }

    public function forChat($serviceSid): static
    {
        $grant = new ChatGrant();

        $grant->setServiceSid($serviceSid);

        $this->getTwilioAccessToken()->addGrant($grant);

        return $this;
    }

    public function getTwilioAccessToken(): AccessToken
    {
        return $this->accessToken = new AccessToken(
            $this->accountSid,
            $this->apiKey,
            $this->apiSecret,
            $this->ttl,
            $this->identity,
            $this->region
        );
    }
}
