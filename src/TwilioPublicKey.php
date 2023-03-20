<?php

namespace Collinped\Twilio;

class TwilioPublicKey
{
    private \Twilio\Rest\Client $twilio;

    /**
     * @var Twilio
     */
    public function __construct(Twilio $twilio)
    {
        $this->twilio = $twilio->sdk();
    }

    public function create($publicKeyName)
    {
        $keyData = ['friendlyName' => $publicKeyName] ?: null;

        return $this->twilio->accounts->v1->credentials
            ->publicKey
            ->create($keyData);
    }

    public function fetch($publicKeySid)
    {
        return $this->twilio->accounts->v1->credentials
            ->publicKey($publicKeySid)
            ->fetch();
    }

    public function get()
    {
        return $this->twilio->accounts->v1->credentials
            ->publicKey
            ->read(20);
    }

    public function update($publicKeySid, $friendlyName)
    {
        return $this->twilio->accounts->v1->credentials
            ->publicKey($publicKeySid)
            ->update(
                ['friendlyName' => $friendlyName]
            );
    }

    public function delete($publicKeySid)
    {
        return $this->twilio->accounts->v1->credentials
            ->publicKey($publicKeySid)
            ->delete();
    }
}
