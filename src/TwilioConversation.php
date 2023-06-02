<?php

namespace Collinped\Twilio;

use Twilio\Rest\Client;

class TwilioConversation
{
    private \Twilio\Rest\Client $twilio;

    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    public function create($conversationName): \Twilio\Rest\Conversations\V1\ConversationInstance
    {
        return $this->twilio->conversations->v1->conversations
            ->create([
                'friendlyName' => $conversationName,
            ]);
    }

    public function get($conversationSid): \Twilio\Rest\Conversations\V1\ConversationInstance
    {
        return $this->twilio->conversations->v1->conversations($conversationSid)
            ->fetch();
    }

    public function addSmsParticipant($conversationSid, $participantNumber, $twilioPhoneNumber): \Twilio\Rest\Conversations\V1\Conversation\ParticipantInstance
    {
        return $this->twilio->conversations->v1->conversations($conversationSid)
            ->participants
            ->create([
                'messagingBindingAddress' => $participantNumber, //Your Personal Mobile Number
                'messagingBindingProxyAddress' => $twilioPhoneNumber, //Your purchased Twilio Phone Number
            ]);
    }

    public function addChatParticipant($conversationSid, $chatIdentity): \Twilio\Rest\Conversations\V1\Conversation\ParticipantInstance
    {
        return $this->twilio->conversations->v1->conversations($conversationSid)
            ->participants
            ->create([
                'identity' => $chatIdentity,
            ]);
    }

    public function enableReachability($conversationSid)
    {
        return $this->twilio->conversations->v1->services($conversationSid)
            ->configuration()
            ->update(
                [
                    'reachabilityEnabled' => true,
                ]
            );
    }

    public function disableReachability($conversationSid)
    {
        return $this->twilio->conversations->v1->services($conversationSid)
            ->configuration()
            ->update(
                [
                    'reachabilityEnabled' => false,
                ]
            );
    }

    //https://www.twilio.com/docs/conversations/api/conversation-webhook-resource
}
