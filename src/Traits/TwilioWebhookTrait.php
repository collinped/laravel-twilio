<?php

namespace Collinped\Twilio\Traits;

use Collinped\Twilio\Events\WebhookHandled;
use Collinped\Twilio\Events\WebhookReceived;
use Collinped\Twilio\Http\Middleware\TwilioRequestValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

trait TwilioWebhookTrait
{
    protected string $callbackKey;

    /**
     * Validate the incoming Twilio Request.
     */
    public function __construct()
    {
        $this->middleware(TwilioRequestValidator::class);
    }

    /**
     * Handle Twilio Video webhook call.
     */
    public function handleWebhook(Request $request): Response
    {
        // TODO - Move validation to each of the individual controllers
        $callbackValidationArray = [
            'StatusCallbackEvent' => 'required_without_all:EventType,MessageStatus,RecordingStatus',
            'EventType' => 'required_without_all:StatusCallbackEvent,MessageStatus,RecordingStatus',
            'MessageStatus' => 'required_without_all:StatusCallbackEvent,EventType,RecordingStatus',
            'RecordingStatus' => 'required_without_all:StatusCallbackEvent,EventType,MessageStatus',
        ];

        $request->validate($callbackValidationArray);

        $this->callbackKey = key($request->only(array_keys($callbackValidationArray)));

        if ($request->isJson()) {
            $payload = json_decode($request->getContent(), true);
        } else {
            $payload = $request->toArray();
        }

        $method = 'handle'.Str::studly($payload[$this->callbackKey]);

        WebhookReceived::dispatch($payload);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            WebhookHandled::dispatch($payload);

            return $response;
        }

        return $this->missingMethod($method);
    }

    /**
     * Handle successful calls on the controller.
     */
    protected function successMethod(array $payload): Response
    {
        return new Response('Webhook Handled: '.$payload[$this->callbackKey], 200);
    }

    /**
     * Handle calls to missing methods on the controller.
     */
    protected function missingMethod($method): Response
    {
        Log::error('Webhook Method Does not exist: '.$method);

        return new Response('Webhook Method Does not exist: '.$method, 403);
    }
}
