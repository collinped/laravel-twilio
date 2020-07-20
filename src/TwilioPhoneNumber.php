<?php


namespace Collinped\Twilio;


class TwilioPhoneNumber extends Twilio
{
    protected $region = 'US';

    /**
     * @var Twilio
     */
    protected $twilio;

    public function __construct(Twilio $twilio) {
        $this->twilio = $twilio->sdk();
    }

    //https://www.twilio.com/docs/phone-numbers/api/availablephonenumberlocal-resource
    public function searchLocal($areaCode)
    {
        return $this->twilio->availablePhoneNumbers($this->region)
                    ->local
                    ->read(["areaCode" => $areaCode], 20);
    }

    public function region($region)
    {
        $this->region = $region;

        return $this;
    }
}

