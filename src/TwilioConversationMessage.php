<?php

namespace Collinped\Twilio;

class TwilioConversationMessage
{
    private \Twilio\Rest\Client $twilio;

    private TwilioConversation $twilioConversation;

    public function __construct(Twilio $twilio, TwilioConversation $twilioConversation)
    {
        $this->twilio = $twilio->sdk();

        $this->twilioConversation = $twilioConversation;
    }

    public function getConversationSid(): string
    {
        return $this->twilioConversation->sid;
    }
}
