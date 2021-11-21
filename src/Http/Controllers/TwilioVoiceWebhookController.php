<?php

namespace Collinped\Twilio\Http\Controllers;

use Illuminate\Routing\Controller;
use Collinped\Twilio\Traits\TwilioWebhookTrait;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TwilioVideoRoomCallback
 * @package App\Http\Controllers\Callback
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

    protected function handleAnswered(array $payload): Response
    {
        return $this->successMethod($payload);
    }

    protected function handleCompleted(array $payload): Response
    {
        return $this->successMethod($payload);
    }
}
