<?php

namespace Collinped\Twilio;

use Twilio\Rest\Client;

class TwilioPhoneNumber
{
    protected string $region = 'US';

    /**
     * @var Twilio
     */
    protected \Twilio\Rest\Client $twilio;

    private string $addressSid;

    private bool $tollFree = false;

    private string $bundleSid;

    private string $smsUrl;

    private string $voiceUrl;

    private bool $asCollection = false;

    /**
     * @param  Client  $twilio
     */
    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function search($searchCriteria = [])
    {
        $tollFreeLocal = $this->tollFree ? 'tollFree' : 'local';

        $phoneNumbers = $this->twilio->availablePhoneNumbers($this->region)
            ->$tollFreeLocal
            ->read($searchCriteria, 20);

        return $this->formatResponse($phoneNumbers);
    }

    //https://www.twilio.com/docs/phone-numbers/api/availablephonenumberlocal-resource
    public function searchByAreaCode($areaCode)
    {
        $phoneNumbers = $this->twilio->availablePhoneNumbers($this->region)
                    ->local
                    ->read(['areaCode' => $areaCode], 20);

        return $this->formatResponse($phoneNumbers);
    }

    public function searchByState($state)
    {
        $phoneNumbers = $this->twilio->availablePhoneNumbers($this->region)
            ->local
            ->read(['inRegion' => $state], 20);

        return $this->formatResponse($phoneNumbers);
    }

    public function purchase($phoneNumber)
    {
        return $this->twilio->incomingPhoneNumbers
            ->create($this->formatPhoneNumberData($phoneNumber));
    }

    public function update($phoneNumber, $data)
    {
        return $this->twilio->incomingPhoneNumbers
            ->update($this->formatPhoneNumberData($phoneNumber, $data));
    }

    protected function formatPhoneNumberData($phoneNumber, $data = [])
    {
        $data['phoneNumber'] = $phoneNumber;
        $this->addressSid ?: $data['addressSid'] = $this->addressSid;
        $this->bundleSid ?: $data['bundleSid'] = $this->bundleSid;
        $this->voiceUrl ?: $data['voiceUrl'] = $this->voiceUrl;
        $this->smsUrl ?: $data['smsUrl'] = $this->smsUrl;

        return $data;
    }

    public function withAddress($addressSid): static
    {
        $this->addressSid = $addressSid;

        return $this;
    }

    public function withBundle($bundleSid): static
    {
        $this->bundleSid = $bundleSid;

        return $this;
    }

    /**
     * Transfer a phone number from the primary account to a subaccount
     */
    public function transferNumberToSubaccount($phoneNumberSid, $subAccountSid)
    {
        return $this->twilio->incomingPhoneNumbers($phoneNumberSid)
            ->update(
                [
                    'accountSid' => $subAccountSid,
                ]
            );
    }

    public function delete($phoneNumberSid): bool
    {
        return $this->twilio->incomingPhoneNumbers($phoneNumberSid)
            ->delete();
    }

    public function voiceUrl($voiceUrl)
    {
        $this->voiceUrl = $voiceUrl;

        return $this;
    }

    public function smsUrl($smsUrl)
    {
        $this->smsUrl = $smsUrl;

        return $this;
    }

    public function region($region): static
    {
        $this->region = $region;

        return $this;
    }

    public function tollFree(): static
    {
        $this->tollFree = true;

        return $this;
    }

    public function asCollection(): static
    {
        $this->asCollection = true;

        return $this;
    }

    public function formatResponse($values)
    {
        if (! $this->asCollection) {
            return $values;
        }

        return collect($values)->map(function ($value) {
            return (object) $value->toArray();
        });
    }
}
