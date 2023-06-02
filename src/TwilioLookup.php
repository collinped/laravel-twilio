<?php

namespace Collinped\Twilio;

class TwilioLookup
{
    protected bool $carrier = false;

    protected bool $caller = false;

    protected array $addons;

    protected array $addonsData;

    private \Twilio\Rest\Client $twilio;

    /**
     * @var Twilio
     */
    public function __construct(Twilio $twilio)
    {
        $this->twilio = $twilio->sdk();
    }

    public function number($phoneNumber)
    {
        $data = [];

        if ($this->carrier) {
            array_push($data['type'], 'carrier');
        }

        if ($this->caller) {
            array_push($data['type'], 'caller-name');
        }

        if ($this->addons) {
            $data['addons'] = $this->addons;
        }

        if ($this->addonsData) {
            $data['addonsData'] = $this->addonsData;
        }

        return $this->twilio->lookups->v1->phoneNumbers($phoneNumber)
            ->fetch($data);
    }

    public function withCarrier(): static
    {
        $this->carrier = true;

        return $this;
    }

    public function withCaller(): static
    {
        $this->caller = true;

        return $this;
    }

    public function withAddon($addon): static
    {
        $this->addons = [
            $addon,
        ];

        return $this;
    }

    public function withAddons(array $addons): static
    {
        $this->addons = $addons;

        return $this;
    }

    public function withAddonData(array $addonData): static
    {
        $this->addonsData = $addonData;

        return $this;
    }

    public function withAddonsData(array $addonData): static
    {
        return $this->withAddonData($addonData);
    }
}
