<?php


namespace Collinped\Twilio;

class TwilioVerify extends Twilio
{
    public function create($verifyServiceName)
    {
       return  $this->twilio->verify->v2->services
            ->create($verifyServiceName);
    }

    public function send($verifySid, $phoneNumber, $method = 'sms')
    {
        $verification =  $this->twilio->verify->v2->services($verifySid)
                            ->verifications
                            ->create($phoneNumber, $method);

        return $verification->status;
    }

    public function check($verfifySid, $phoneNumber, $code)
    {
        $verificationCheck = $this->twilio->verify->v2->services($verfifySid)
                                ->verificationChecks
                                ->create($code, // code
                                    array("to" => $phoneNumber)
                                );

        return $verificationCheck->status;
    }
}
