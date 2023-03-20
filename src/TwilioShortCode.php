<?php

namespace Collinped\Twilio;

class TwilioShortCode
{
    private \Twilio\Rest\Client $twilio;

    private string $sid;

    private bool $asCollection = true;

    /**
     * @var Twilio
     */
    public function __construct(Twilio $twilio)
    {
        $this->twilio = $twilio->sdk();
    }

    public function all($limit = 20)
    {
        $shortCodes = $this->twilio->shortCodes
            ->read([], $limit);

        return $this->formatResponse($shortCodes);
    }

    public function search($shortCode, $limit = 20)
    {
        $phoneNumbers = $this->twilio->shortCodes
            ->read(
                [
                    'shortCode' => $shortCode,
                ],
                $limit
            );

        return $this->formatResponse($phoneNumbers);
    }

    public function update($data = [])
    {
        return $this->twilio->shortCodes($this->sid)
            ->update(
                $data
            );
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
