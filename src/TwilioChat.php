<?php


namespace Collinped\Twilio;

use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;

class TwilioChat
{
    //https://www.twilio.com/docs/chat/tutorials/chat-application-php-laravel

    protected string $serviceSid;
    protected string $appName;
    protected string $deviceId;
    protected string $identity;

    public function generate(Request $request, ChatGrant $chatGrant)
    {
        $twilioChatServiceSid = $this->serviceSid;
        $appName = $this->appName;
        $deviceId = $this->deviceId;
        $identity =$this->identity;
        $accessToken = $this->accessToken();

        $endpointId = $appName . ":" . $identity . ":" . $deviceId;

        $accessToken->setIdentity($identity);

        $chatGrant->setServiceSid($twilioChatServiceSid);
        $chatGrant->setEndpointId($endpointId);

        $accessToken->addGrant($chatGrant);

        $response = array(
            'identity' => $identity,
            'token' => $accessToken->toJWT()
        );

        return response()->json($response);
    }

    /**
     * Set the Device ID.
     *
     * @param string $deviceId
     * @return $this
     */
    public function deviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Set the Identity.
     *
     * @param string $identity
     * @return $this
     */
    public function identity($identity)
    {
        $this->identity = $identity;

        return $this;
    }

    /**
     * Set the Service SID.
     *
     * @param string $serviceSid
     * @return $this
     */
    public function serviceSid($serviceSid)
    {
        $this->serviceSid = $serviceSid;

        return $this;
    }

    private function accessToken(): AccessToken
    {
        $twilioAccountSid = config('twilio.account_sid');
        $twilioApiKey = config('twilio.api_key');
        $twilioApiSecret = config('twilio.api_secret');

        return new AccessToken(
            $twilioAccountSid,
            $twilioApiKey,
            $twilioApiSecret,
            3600
        );
    }
}
