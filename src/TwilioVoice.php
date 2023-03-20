<?php

namespace Collinped\Twilio;

use Twilio\Rest\Api\V2010\Account\CallInstance;
use Twilio\Rest\Client;
use Twilio\TwiML\TwiML;
use Twilio\TwiML\VoiceResponse;

class TwilioVoice
{
    public const STATUS_INITIATED = 'initiated';

    public const STATUS_RINGING = 'ringing';

    public const STATUS_ANSWERED = 'answered';

    public const STATUS_COMPLETED = 'completed';

    public const RECORDING_STATUS_ABSENT = 'absent';

    public const RECORDING_STATUS_IN_PROGRESS = 'in-progress';

    public const RECORDING_STATUS_COMPLETED = 'completed';

    protected ?string $method = null;

    protected ?string $status = null;

    protected ?string $fallbackUrl = null;

    protected ?string $fallbackMethod = null;

    protected ?string $from = null;

    private string $statusCallbackMethod = 'POST';

    private ?array $statusCallbackEvents = null;

    private ?string $statusCallbackUrl = null;

    private ?string $url = null;

    private \Twilio\Rest\Client $twilio;

    /**
     * @param  Client  $twilio
     */
    public function __construct(Client $twilio)
    {
        $this->twilio = $twilio;
    }

    /**
     * @param  string  $to
     * @param  string|callable  $message
     * @param  array  $params
     *
     * @link https://www.twilio.com/docs/api/voice/making-calls Documentation
     *
     * @return \Twilio\Rest\Api\V2010\Account\CallInstance
     */
    public function callWithMessage(string $to, $message, array $params = []): CallInstance
    {
        if (is_callable($message)) {
            $message = $this->twiml($message);
        }

        if ($message instanceof TwiML) {
            $params['twiml'] = (string) $message;
        } else {
            $params['url'] = $message;
        }

        return $this->twilio->calls->create(
            $to,
            $this->from,
            $params
        );
    }

    private function twiml(callable $callback): TwiML
    {
        $message = new VoiceResponse();

        call_user_func($callback, $message);

        return $message;
    }

    public function sendToVoicemail(string $message = 'Please leave a message after the beep.'): VoiceResponse
    {
        $response = new VoiceResponse();

        $response->say($message);
        $response->record();
        $response->hangup();

        return $response;
    }

    /**
     * Set the message url.
     *
     * @param  string  $url
     * @return $this
     */
    public function url(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set the message url request method.
     *
     * @param  string  $method
     * @return $this
     */
    public function method(string $method): static
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Set the status for the current calls.
     *
     * @param  string  $status
     * @return $this
     */
    public function status($status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set the fallback url.
     *
     * @param  string  $fallbackUrl
     * @return $this
     */
    public function fallbackUrl(string $fallbackUrl): static
    {
        $this->fallbackUrl = $fallbackUrl;

        return $this;
    }

    /**
     * Set the fallback url request method.
     *
     * @param  string  $fallbackMethod
     * @return $this
     */
    public function fallbackMethod(string $fallbackMethod): static
    {
        $this->fallbackMethod = $fallbackMethod;

        return $this;
    }

    public function statusCallbackUrl(string $statusCallbackUrl): static
    {
        $this->statusCallbackUrl = $statusCallbackUrl;

        return $this;
    }

    /**
     * Values include initiated, ringing, answered, completed
     *
     * @param  array  $statusCallbackEvents
     * @return $this
     */
    public function statusCallbackEvent(array $statusCallbackEvents): static
    {
        $this->statusCallbackEvents = $statusCallbackEvents;

        return $this;
    }

    public function statusCallbackMethod($statusCallbackMethod): static
    {
        $this->statusCallbackMethod = $statusCallbackMethod;

        return $this;
    }
}
