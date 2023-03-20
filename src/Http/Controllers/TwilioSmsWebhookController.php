<?php

namespace Collinped\Twilio\Http\Controllers;

use Collinped\Twilio\Traits\TwilioWebhookTrait;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class TwilioSmsWebhookController extends Controller
{
    use TwilioWebhookTrait;

    protected function handleAccepted(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleQueued(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleSending(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleSent(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleFailed(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleDelivered(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleUndelivered(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleReceiving(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleReceived(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    /**
     * WhatsApp only
     */
    protected function handleRead(array $payload): Response
    {
        return $this->successMethod($payload);
    }
}
