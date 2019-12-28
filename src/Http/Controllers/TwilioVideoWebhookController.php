<?php

namespace Collinped\Twilio\Http\Controllers;

use App\Http\Controllers\Controller;
use Collinped\Twilio\TwilioWebhook;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TwilioVideoRoomCallback
 * @package App\Http\Controllers\Callback
 */
class TwilioVideoWebhookController extends Controller
{
    use TwilioWebhook;

    /**
     * Handle a room created from a Twilio Video callback.
     *
     *
     */
    protected function handleRoomCreated(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    /**
     * @param array $payload
     */
    protected function handleRoomEnded(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleParticipantConnected(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    /**
     * @param array $payload
     */
    protected function handleParticipantDisconnected(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleTrackAdded(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleTrackRemoved(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleTrackEnabled(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleTrackDisabled(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleRecordingStarted(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleRecordingCompleted(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleRecordingFailed(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    //Composition Webhooks

    protected function handleCompositionEnqueued(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleCompositionHookFailed(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleCompositionStarted(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleCompositionAvailable(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleCompositionProgress(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }

    protected function handleCompositionFailed(array $payload)
    {
        return new Response('Webhook Handled: ' . $payload['StatusCallbackEvent'], 200);
    }
}
