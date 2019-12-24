<?php

namespace Collinped\TwilioVideo\Http\Controllers;

use App\Http\Controllers\Controller;
use Collinped\TwilioVideo\TwilioVideoWebhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Collinped\TwilioVideo\Http\Middleware\VerifyWebhookSignature;
use Twilio\Events\WebhookHandled;
use Twilio\Events\WebhookReceived;

/**
 * Class TwilioVideoRoomCallback
 * @package App\Http\Controllers\Callback
 */
class WebhookController extends Controller
{
    use TwilioVideoWebhook;

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
