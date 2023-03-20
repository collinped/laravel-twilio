<?php

namespace Collinped\Twilio;

class TwilioMessageService
{
    //https://www.twilio.com/docs/sms/services/api

    private \Twilio\Rest\Client $twilio;

    /**
     * @var Twilio
     */
    public function __construct(Twilio $twilio)
    {
        $this->twilio = $twilio->sdk();
    }

    public function create($serviceName)
    {
        return $this->twilio->messaging->v1->services
                ->create($serviceName);
    }

    public function fetch($serviceSid)
    {
        $this->twilio->messaging->v1->services($serviceSid)
            ->fetch();
    }

    public function read()
    {
        return $this->twilio->messaging->v1->services
                ->read(20);
    }

    public function update($serviceSid, $serviceName)
    {
        return $this->twilio->messaging->v1->services($serviceSid)
            ->update([
                'friendlyName' => $serviceName,
            ]);
    }

    public function delete($serviceSid)
    {
        return $this->twilio->messaging->v1->services($serviceSid)
            ->delete();
    }
}
