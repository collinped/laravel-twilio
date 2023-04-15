<?php

namespace Collinped\Twilio;

use Twilio\Rest\Client;

class TwilioRegulation
{
    private \Twilio\Rest\Client $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function all(): array
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
            ->regulations
            ->read(
                [
                    'endUserType' => 'individual',
                    'isoCountry' => 'au',
                    'numberType' => 'local',
                ],
                20
            );
    }

    public function find($regulationSid)
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
            ->regulations($regulationSid)
            ->fetch();
    }
}
