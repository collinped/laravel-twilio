<?php

namespace Collinped\Twilio\Http\Controllers;

use Collinped\Twilio\Traits\TwilioWebhookTrait;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TwilioVoiceWebhookController
 */
class TwilioVoiceWebhookController extends Controller
{
    use TwilioWebhookTrait;

    protected function handleInitiated(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleRinging(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleInProgress(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleAnswered(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleNoAnswer(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCompleted(array $payload): Response
    {
        return $this->successMethod($payload);
    }
}
