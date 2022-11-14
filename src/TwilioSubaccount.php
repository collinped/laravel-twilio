<?php

namespace Collinped\Twilio;

class TwilioSubaccount
{
    protected $subAccountSid;

    protected $subAccountName;

    private \Twilio\Rest\Client $twilio;

    /**
     * @var Twilio
     */
    public function __construct(Twilio $twilio, $subAccountSid)
    {
        $this->twilio = $twilio->sdk();

        $this->subAccountSid = $subAccountSid;
    }

    public function create($subaccountName)
    {
        return $this->twilio->api->v2010->accounts
            ->create([
                'friendlyName' => $subaccountName,
            ]);
    }

    public function fetch()
    {
        return $this->twilio->api->v2010->accounts($this->subAccountSid)
            ->fetch();
    }

    public function get($subAccountName)
    {
        $subAccountName = $subAccountName ?: $this->subAccountName;

        return $this->twilio->api->v2010->accounts
            ->read(['friendlyName' => $subAccountName], 20);
    }

    public function suspend()
    {
        return $this->twilio->api->v2010->accounts($this->subAccountSid)
            ->update(['status' => 'suspended']);
    }

    public function activate()
    {
        return $this->twilio->api->v2010->accounts($this->subAccountSid)
            ->update(['status' => 'active']);
    }

    public function close()
    {
        return $this->twilio->api->v2010->accounts($this->subAccountSid)
            ->update(['status' => 'closed']);
    }

    public function name($subAccountName)
    {
        $this->subAccountName = $subAccountName;

        return $this;
    }
}
