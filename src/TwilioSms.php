<?php


namespace Collinped\Twilio;


class TwilioSms extends Twilio
{
    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $message = null;

    /**
     * @var string
     */
    protected $statusCallback = null;

    /**
     * @var array
     */
    protected $media = null;

    /**
     * @var bool
     */
    protected $whatsApp = false;

    /**
     * @var bool
     */
    protected $feedback = false;

    /**
     * @var Twilio
     */
    protected $twilio;

    public function __construct(Twilio $twilio) {
        $this->twilio = $twilio->sdk();
    }

    public function all()
    {

    }

    /**
     * Send the Twilio Message.
     *
     * @param array $params
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function send($params = [])
    {
        $to = ($this->whatsApp ? 'whatsapp:' . $this->to : $this->to);

        $params['from'] = ($this->whatsApp ? 'whatsapp:' . $this->from : $this->from);
        $params['body'] = $params['message'] ?? $this->message ?? null;
        //Pop an error because an body is required
        $params['statusCallback'] = $params['statusCallback'] ?? $this->statusCallback ?? null;

        if (!empty($media)) {
            $params['mediaUrl'] = $media;
        }

        //Incorporate Message Feedback - https://www.twilio.com/docs/sms/api/message-feedback-resource#messagefeedback-properties

        return $this->twilio->messages->create($to, $params);
    }

    public function find($messageSid)
    {
        return $this->twilio->messages($messageSid)
                ->fetch();
    }

    public function redact($messageSid)
    {
        return $this->twilio->messages($messageSid)
                ->update(["body" => ""]);
    }

    public function delete($messageSid)
    {
        return $this->twilio->messages($messageSid)
            ->delete();
    }

    public function fetchMedia($messageSid, $mediaSid)
    {
        return $this->twilio->messages($messageSid)
                ->media($mediaSid)
                ->fetch();
    }

    public function readMedia($messageSid)
    {
        return $this->twilio->messages($messageSid)
                ->media
                ->read(array(), 20);
    }

    public function deleteMedia($messageSid, $mediaSid)
    {
        return $this->twilio->messages($messageSid)
            ->media($mediaSid)
            ->delete();
    }

    /**
     * Set the Twilio number to send to.
     *
     * @param string $phoneNumber
     * @return $this
     */
    public function to($phoneNumber)
    {
        $this->to = $phoneNumber;

        return $this;
    }

    /**
     * Set the Twilio number to send from.
     *
     * @param string $phoneNumber
     * @return $this
     */
    public function from($phoneNumber)
    {
        $this->from = $phoneNumber;

        return $this;
    }

    /**
     * Set the body of the message.
     *
     * @param string $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the status callback.
     *
     * @param string $statusCallback
     * @return $this
     */
    public function statusCallback($statusCallback)
    {
        $this->statusCallback = $statusCallback;

        return $this;
    }

    /**
     * Add image media.
     *
     * @param string $media
     * @return $this
     */
    public function withMedia($media)
    {
        $this->media = (is_array($media) ?: [$media]);

        //TODO - Validate teh file extensions

        return $this;
    }

    public function feedback()
    {
        $this->feedback = true;

        return $this;
    }

    /**
     * Send message via Whats App.
     *
     * @return $this
     */
    public function whatsApp()
    {
        $this->whatsApp = true;

        return $this;
    }

}
