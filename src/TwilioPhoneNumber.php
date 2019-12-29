<?php


namespace Collinped\Twilio;


class TwilioPhoneNumber extends Twilio
{
    //https://www.twilio.com/docs/phone-numbers/api/availablephonenumberlocal-resource

    public function searchLocal($areaCode)
    {
        return $this->twilio->availablePhoneNumbers("US")
                    ->local
                    ->read(array("areaCode" => $areaCode), 20);
    }
}

