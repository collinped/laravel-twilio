<?php

namespace Collinped\Twilio;

class TwilioVoiceRecording
{
    protected string $call;

    protected string $conference;

    private \Twilio\Rest\Client $twilio;

    /**
     * @param  Twilio  $twilio
     */
    public function __construct(Twilio $twilio)
    {
        $this->twilio = $twilio->sdk();
    }

    public function all($options = [])
    {
        return $this->twilio->recordings
            ->read($options, 20);
    }

    public function fetch()
    {
    }

    public function startRecording($call)
    {
        $call = $call ?: $this->call;

        return $this->twilio->calls($call)
            ->recordings
            ->create();
    }

    public function pauseRecording($recording, $call, $type = 'skip')
    {
        $call = $call ?: $this->call;

        $callType = $this->conference ? 'conference' : 'calls';

        return $this->twilio->$callType($call)
            ->recordings($recording)
            ->update('paused', ['pauseBehavior' => $type]);
    }

    public function resumeRecording($recording, $call)
    {
        $call = $call ?: $this->call;

        return $this->twilio->calls($call)
            ->recordings($recording)
            ->update('in-progress');
    }

    public function stopRecording($recording, $call)
    {
        $call = $call ?: $this->call;

        return $this->twilio->calls($call)
            ->recordings($recording)
            ->update('stopped');
    }

    public function call($call)
    {
        $this->call = $call;

        return $this;
    }

    public function conference($conferenceSid)
    {
        $this->conference = $conferenceSid;

        return $this;
    }
}
