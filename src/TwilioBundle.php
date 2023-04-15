<?php

namespace Collinped\Twilio;

use Twilio\Rest\Client;

class TwilioBundle
{
    private \Twilio\Rest\Client $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function all(): array
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
                    ->bundles
                    ->read([], 20);
    }

    public function create($bundleName, $email): \Twilio\Rest\Numbers\V2\RegulatoryCompliance\BundleInstance
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
                    ->bundles
                    ->create(
                        $bundleName,
                        $email,
                        [
                            'endUserType' => 'business',
                            'isoCountry' => 'de',
                            'numberType' => 'local',
                            'statusCallback' => 'https://twilio.status.callback.com',
                        ]
                    );
    }

    public function find($bundleSid): \Twilio\Rest\Numbers\V2\RegulatoryCompliance\BundleInstance
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
                    ->bundles($bundleSid)
                    ->fetch();
    }

    public function update($bundleSid)
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
            ->bundles($bundleSid)
            ->update(
                [
                    'friendlyName' => 'UpdatedSubmittedFriendlyName',
                    'status' => 'pending-review',
                ]
            );
    }

    public function delete($bundleSid): bool
    {
        return $this->twilio->numbers->v2->regulatoryCompliance
            ->bundles($bundleSid)
            ->delete();
    }
}
