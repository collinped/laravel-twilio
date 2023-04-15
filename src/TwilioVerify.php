<?php

namespace Collinped\Twilio;

use Illuminate\Support\Str;

class TwilioVerify
{
    protected \Twilio\Rest\Client $twilio;

    public function __construct(Twilio $twilio)
    {
        $this->twilio = $twilio->sdk();
    }

    public function create($verifyServiceName): \Twilio\Rest\Verify\V2\ServiceInstance
    {
        return $this->twilio->verify->v2->services
            ->create($verifyServiceName);
    }

    public function send($verifySid, $phoneNumber, $method = 'sms'): string
    {
        $verification = $this->twilio->verify->v2->services($verifySid)
                            ->verifications
                            ->create($phoneNumber, $method);

        return $verification->status;
    }

    public function check($verifySid, $phoneNumber, $code = null): string
    {
        $code = is_null($code) ? Str::upper(Str::random(6)) : $code;

        $verificationCheck = $this->twilio->verify->v2->services($verifySid)
                                ->verificationChecks
                                ->create(
                                    $code,
                                    ['to' => $phoneNumber]
                                );

        return $verificationCheck->status;
    }
}
