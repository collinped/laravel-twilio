<?php

namespace Collinped\Twilio;

class TwilioTrunk
{
    private \Twilio\Rest\Client $twilio;

    public function __construct(Twilio $twilio)
    {
        $this->twilio = $twilio->sdk();
    }

    public function create(): \Twilio\Rest\Trunking\V1\TrunkInstance
    {
        return $this->twilio->trunking->v1->trunks
            ->create();
    }

    public function get()
    {
        return $this->twilio->trunking->v1->trunks
            ->read(20);
    }

    public function fetch($trunkSid): \Twilio\Rest\Trunking\V1\TrunkInstance
    {
        return $this->twilio->trunking->v1->trunks($trunkSid)
            ->fetch();
    }

    public function delete($trunkSid): bool
    {
        return $this->twilio->trunking->v1->trunks($trunkSid)
            ->delete();
    }
}
