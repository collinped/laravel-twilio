<?php

namespace Collinped\Twilio\Tests\Feature\Http\Controllers;

use Collinped\Twilio\Tests\TestCase;

class TwilioConversationWebhookControllerTest extends TestCase
{
    /** @test */
    public function validation_fails_if_sms_webhook_does_not_contain_valid_callback_status()
    {
        $response = $this->post(route('twilio.conversation.webhook'));

        $response->assertStatus(302);
    }

    /** @test */
    public function validation_succeeds_if_webhook_does_contain_valid_callback_status()
    {
        $response = $this->post(route('twilio.conversation.webhook'), [
            'EventType' => 'onMessageAdd',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function validation_fails_if_webhook_does_not_contain_a_valid_method()
    {
        $response = $this->post(route('twilio.conversation.webhook'), [
            'EventType' => 'test',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function validation_succeeds_if_webhook_does_contain_a_valid_method()
    {
        $validStatuses = [
            'onMessageAdd',
            'onMessageRemove',
            'onMessageUpdate',
            'onConversationAdd',
            'onConversationRemove',
            'onConversationUpdate',
            'onUserUpdate',
            'onMessageAdded',
            'onMessageRemoved',
            'onMessageUpdated',
            'onConversationAdded',
            'onConversationRemoved',
            'onConversationUpdated',
            'onParticipantAdded',
            'onParticipantRemoved',
            'onParticipantUpdated',
            'onConversationStateUpdated',
            'onDeliveryUpdated',
            'onUserAdded',
            'onUserUpdated'
        ];

        foreach ($validStatuses as $validStatus) {
            $response = $this->post(route('twilio.conversation.webhook'), [
                'EventType' => $validStatus,
            ]);

            $response->assertStatus(200);
        }
    }
}
