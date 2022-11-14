<?php

namespace Collinped\Twilio;

use Twilio\Rest\Client;

class TwilioSupportingDocument
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
    }

    public function find($evaluationSid, $bundleSid): \Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle\EvaluationInstance
    {
    }

    public function create(
        $supportingDocumentName = null,
        $supportingDocumentType = null,
        $addressSids = []
    ): \Twilio\Rest\Numbers\V2\RegulatoryCompliance\SupportingDocumentInstance {
        return $this->twilio->numbers->v2->regulatoryCompliance
            ->supportingDocuments
            ->create(
                $supportingDocumentName, // friendlyName
                $supportingDocumentType, // type
                [
                    'attributes' => [
                        'address_sids' => $addressSids,
                    ],
                ]
            );
    }
}
