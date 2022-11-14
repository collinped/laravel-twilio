<?php

namespace Collinped\Twilio\Tests\Feature\Http\Controllers;

use Collinped\Twilio\Tests\TestCase;

class TwilioVideoWebhookControllerTest extends TestCase
{
    /** @test */
    public function validation_fails_if_sms_webhook_does_not_contain_valid_callback_status()
    {
        $response = $this->post(route('twilio.video.webhook'));

        $response->assertStatus(302);
    }

    /** @test */
    public function validation_succeeds_if_webhook_does_contain_valid_callback_status()
    {
        $response = $this->post(route('twilio.video.webhook'), [
            'StatusCallbackEvent' => 'room-created',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function validation_fails_if_webhook_does_not_contain_a_valid_method()
    {
        $response = $this->post(route('twilio.video.webhook'), [
            'StatusCallbackEvent' => 'test',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function validation_succeeds_if_webhook_does_contain_a_valid_method()
    {
        $validStatuses = [
            'room-created',
            'room-ended',
            'participant-connected',
            'participant-disconnected',
            'track-added',
            'track-removed',
            'track-enabled',
            'track-disabled',
            'recording-started',
            'recording-completed',
            'recording-failed',
        ];

        foreach ($validStatuses as $validStatus) {
            $response = $this->post(route('twilio.video.webhook'), [
                'StatusCallbackEvent' => $validStatus,
            ]);

            $response->assertStatus(200);
        }
    }
}
