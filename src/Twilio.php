<?php

namespace Collinped\Twilio;

use Collinped\Twilio\Exception\InvalidArgumentException;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class Twilio
{
    /**
     * @var string
     */
    protected ?string $accountSid = null;

    /**
     * @var string
     */
    protected ?string $authToken = null;

    /**
     * @var string
     */
    protected ?string $subAccountSid = null;

    protected string $apiKey;

    protected string $apiSecret;

    public static bool $enableDebugging = false;

    protected Client $twilio;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?string $accountSid = null,
        ?string $authToken = null,
        ?string $subAccountSid = null
    ) {
        if (! is_null($accountSid)) {
            $this->setAccountSid($accountSid);
        }

        if (! is_null($authToken)) {
            $this->setAuthToken($authToken);
        }

        if (! is_null($subAccountSid)) {
            $this->setSubAccount($subAccountSid);
        }
    }

    /**
     * Indicates if Twilio routes will be registered.
     */
    public static bool $registersRoutes = true;

    /**
     * Configure Twilio to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes(): Twilio
    {
        static::$registersRoutes = false;

        return new static();
    }

    public static function debug(): Twilio
    {
        static::$enableDebugging = true;

        return new static();
    }

    /**
     * @throws ConfigurationException
     */
    public function sdk(): Client
    {
        return $this->getTwilio();
    }

    /**
     * Set the Account SID.
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setAccountSid($accountSid): Twilio
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
    public function setAuthToken($authToken): Twilio
    {
        if (! is_string($authToken) || empty($authToken)) {
            throw new InvalidArgumentException('A valid Authorization Token is required.');
        }

        $this->authToken = $authToken;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setSubAccount($subAccountSid): Twilio
    {
        if (! is_string($subAccountSid) && ! is_null($subAccountSid)) {
            throw new InvalidArgumentException('A valid Subaccount SID is required.');
        }

        $this->subAccountSid = $subAccountSid ?: $this->accountSid;

        return $this;
    }

    /**
     * SubAccount resource.
     *
     * @return TwilioSms
     */
    public function subAccount(): TwilioSubaccount
    {
        return new TwilioSubaccount($this, $this->subAccountSid);
    }

    /**
     * Api Key resource.
     */
    public function apiKey(): TwilioApiKey
    {
        return new TwilioApiKey($this->getTwilio());
    }

    /**
     * Phone Number resource.
     */
    public function phoneNumber(): TwilioPhoneNumber
    {
        return new TwilioPhoneNumber($this->getTwilio());
    }

    /**
     * Sms resource.
     */
    public function sms(): TwilioSms
    {
        return new TwilioSms($this->getTwilio());
    }

    /**
     * Voice resource.
     *
     * @return TwilioSms
     */
    public function voice(): TwilioVoice
    {
        return new TwilioVoice($this->getTwilio());
    }

    /**
     * Video resource.
     *
     * @return TwilioSms
     */
    public function video(): TwilioVideo
    {
        return new TwilioVideo($this->getTwilio());
    }

    /**
     * Conversation resource.
     */
    public function conversation(): TwilioConversation
    {
        return new TwilioConversation($this->getTwilio());
    }

    /**
     * @throws ConfigurationException
     */
    public function getTwilio(): Client
    {
        return $this->twilio = new Client($this->accountSid, $this->authToken, $this->subAccountSid);
    }

//    public function __get(string $name)
//    {
//        $method = 'get' . \ucfirst($name);
//        if (\method_exists($this->twilio, $method)) {
//            return $this->twilio->$name();
//        }
//
//        throw new TwilioException('Unknown domain ' . $name);
//    }
//
//    /**
//     * @throws TwilioException
//     */
//    public function __call(string $name, array $arguments)
//    {
//        $contextMethod = 'context' . \ucfirst($name);
//
//        if (\method_exists($this->twilio, $contextMethod)) {
//            return \call_user_func([$this->twilio, $contextMethod], $arguments);
//        }
//
//        throw new TwilioException('MY ERROR - Resource does not have a context');
//    }
}
