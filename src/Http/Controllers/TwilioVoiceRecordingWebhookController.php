<?php

namespace Collinped\Twilio\Http\Controllers;

use Collinped\Twilio\Traits\TwilioWebhookTrait;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TwilioVideoRoomCallback
 */
class TwilioVoiceRecordingWebhookController extends Controller
{
    use TwilioWebhookTrait;

    protected function handleInProgress(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCompleted(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleAbsent(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleFailed(array $payload): Response
    {
        return $this->successMethod($payload);
    }
}
