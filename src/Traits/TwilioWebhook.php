<?php

namespace Collinped\Twilio;

use Collinped\Twilio\Http\Middleware\VerifyTwilioSignature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Collinped\Twilio\Events\WebhookHandled;
use Collinped\Twilio\Events\WebhookReceived;

trait TwilioWebhook {

    /**
     * Create a TwilioVideoRoomCallback instance.
     */
    public function __construct()
    {
        $this->middleware(VerifyTwilioSignature::class);
    }

    /**
     * Handle Twilio Video webhook call.
     * @param Request $request
     * @return Response
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        $method = 'handle'.Str::studly($payload['StatusCallbackEvent']);

        WebhookReceived::dispatch($payload);
        //Log::debug('Webhook Recieved: ' . $method);

        if (method_exists($this, $method)) {
            $response = $this->{$method}($payload);

            WebhookHandled::dispatch($payload);

            return $response;
        }

        return $this->missingMethod($method);
    }

    /**
     * Handle successful calls on the controller.
     *
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function successMethod($parameters = [])
    {
        return new Response('Webhook Handled', 200);
    }
    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  array  $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function missingMethod($method, $parameters = [])
    {
        Log::error('Webhook Method Does not exist: ' . $method);

        return new Response('Webhook Method Does not exist: ' . $method, 403);
    }

}
