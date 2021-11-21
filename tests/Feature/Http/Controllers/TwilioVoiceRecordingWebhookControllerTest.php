<?php

namespace Collinped\Twilio\Tests\Feature\Http\Controllers;

use Collinped\Twilio\Tests\TestCase;

class TwilioVoiceRecordingWebhookControllerTest extends TestCase
{
    /** @test */
    public function validation_fails_if_sms_webhook_does_not_contain_valid_callback_status()
    {
        $response = $this->post(route('twilio.voice-recording.webhook'));

        $response->assertStatus(302);
    }

    /** @test */
    public function validation_succeeds_if_webhook_does_contain_valid_callback_status()
    {
        $response = $this->post(route('twilio.voice-recording.webhook'), [
            'RecordingStatus' => 'in-progress',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function validation_fails_if_webhook_does_not_contain_a_valid_method()
    {
        $response = $this->post(route('twilio.voice-recording.webhook'), [
            'RecordingStatus' => 'test',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function validation_succeeds_if_webhook_does_contain_a_valid_method()
    {
        $validStatuses = [
            'in-progress',
            'completed',
            'absent',
            'failed'
        ];

        foreach ($validStatuses as $validStatus) {
            $response = $this->post(route('twilio.voice-recording.webhook'), [
                'RecordingStatus' => $validStatus,
            ]);

            $response->assertStatus(200);
        }
    }
}
