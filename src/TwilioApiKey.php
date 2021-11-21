<?php

namespace Collinped\Twilio;

use Twilio\Rest\Client;

class TwilioApiKey
{
    private \Twilio\Rest\Client $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function create($apiKeyName)
    {
        $keyData = ["friendlyName" => $apiKeyName] ?: null;

        return $this->twilio->newKeys
            ->create($keyData);
    }

    public function fetch($apiKey)
    {
        return $this->twilio->keys($apiKey)
            ->fetch();
    }

    public function get()
    {
        return $this->twilio->keys
            ->read(20);
    }

    public function update($apiKey, $friendlyName)
    {
        return $this->twilio->keys($apiKey)
            ->update(["friendlyName" => $friendlyName]);
    }

    public function delete($apiKey)
    {
        return $this->twilio->keys($apiKey)
            ->delete();
    }
}
