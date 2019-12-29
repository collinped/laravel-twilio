<?php


namespace Collinped\Twilio;


class TwilioConversation extends Twilio
{
    public function create($conversationName)
    {
        return $this->twilio->conversations->v1->conversations
            ->create([
                    "friendlyName" => $conversationName
            ]);
    }

    public function get($conversationSid)
    {
        return $this->twilio->conversations->v1->conversations($conversationSid)
                    ->fetch();
    }

    public function addSmsParticipant($conversationSid, $participantNumber, $twilioPhoneNumber)
    {
        return $this->twilio->conversations->v1->conversations($conversationSid)
                    ->participants
                    ->create([
                            "messagingBindingAddress" => $participantNumber, //Your Personal Mobile Number
                            "messagingBindingProxyAddress" => $twilioPhoneNumber //Your purchased Twilio Phone Number
                    ]);
    }

    public function addChatParticipant($conversationSid, $chatIdentity)
    {
        return $this->twilio->conversations->v1->conversations($conversationSid)
                ->participants
                ->create([
                    "identity" => $chatIdentity
                ]);
    }

    //https://www.twilio.com/docs/conversations/api/conversation-webhook-resource
}
