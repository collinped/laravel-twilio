<?php

namespace Collinped\Twilio\Http\Controllers;

use Collinped\Twilio\Traits\TwilioWebhookTrait;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TwilioVoiceDialStatusWebhookController
 */
class TwilioVoiceDialStatusWebhookController extends Controller
{
    use TwilioWebhookTrait;

    protected function handleBusy(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleNoAnswer(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleAnswered(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCompleted(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleFailed(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCanceled(array $payload): Response
    {
        return $this->successMethod($payload);
    }
}
