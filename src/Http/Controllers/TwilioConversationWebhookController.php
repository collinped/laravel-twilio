<?php

namespace Collinped\Twilio\Http\Controllers;

use Illuminate\Routing\Controller;
use Collinped\Twilio\Traits\TwilioWebhookTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TwilioVideoRoomCallback
 * @package App\Http\Controllers\Callback
 */
class TwilioConversationWebhookController extends Controller
{
    use TwilioWebhookTrait;

    // Pre-Action Webhooks

    protected function handleOnMessageAdd(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnMessageRemove(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnMessageUpdate(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnConversationAdd(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnConversationRemove(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnConversationUpdate(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnParticipantAdd(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnParticipantUpdate(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnUserUpdate(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    // Post-Action Webhooks

    protected function handleOnMessageAdded(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnMessageRemoved(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnMessageUpdated(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnConversationAdded(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnConversationRemoved(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnConversationUpdated(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnParticipantAdded(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnParticipantRemoved(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnParticipantUpdated(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnConversationStateUpdated(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnDeliveryUpdated(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnUserAdded(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleOnUserUpdated(array $payload): Response
    {
        return $this->successMethod($payload);
    }
}
