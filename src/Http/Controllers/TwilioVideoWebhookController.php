<?php

namespace Collinped\Twilio\Http\Controllers;

use Illuminate\Routing\Controller;
use Collinped\Twilio\Traits\TwilioWebhookTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TwilioVideoRoomCallback
 * @package App\Http\Controllers\Callback
 */
class TwilioVideoWebhookController extends Controller
{
    use TwilioWebhookTrait;

    protected function handleRoomCreated(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleRoomEnded(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleParticipantConnected(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleParticipantDisconnected(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleTrackAdded(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleTrackRemoved(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleTrackEnabled(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleTrackDisabled(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleRecordingStarted(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleRecordingCompleted(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleRecordingFailed(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    //Composition Webhooks

    protected function handleCompositionEnqueued(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCompositionHookFailed(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCompositionStarted(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCompositionAvailable(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCompositionProgress(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCompositionFailed(array $payload): Response
    {
        return $this->successMethod($payload);
    }
}
