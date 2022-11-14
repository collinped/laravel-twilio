<?php

namespace Collinped\Twilio;

use Twilio\Rest\Client;

class TwilioEvaluation
{
    private \Twilio\Rest\Client $twilio;

    /**
     * @param  Client  $twilio
     */
    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function all($bundleSid): array
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
                    ->bundles($bundleSid)
                    ->evaluations
                    ->read(20);
    }

    public function find($evaluationSid, $bundleSid): \Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle\EvaluationInstance
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
            ->bundles($bundleSid)
            ->evaluations($evaluationSid)
            ->fetch();
    }

    public function create($bundleSid): \Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle\EvaluationInstance
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
            ->bundles($bundleSid)
            ->evaluations
            ->create();
    }
}
