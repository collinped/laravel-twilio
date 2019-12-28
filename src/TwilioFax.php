<?php


namespace Collinped\Twilio;


class TwilioFax extends Twilio
{
    protected $to;
    protected $from;

    public function all(array $params = [], $limit = null, $page= null)
    {
        return $this->twilio->fax->v1->faxes
            ->read(array(), 20);
    }

    public function send($media)
    {
        $this->twilio->fax->v1->faxes
            ->create($this->to,
                $media, [
                    "from" => $this->from
                ]
            );
    }

    public function to($faxNumber)
    {
        $this->to = $faxNumber;

        return $this;
    }

    public function from($phoneNumber)
    {
        $this->to = $phoneNumber;

        return $this;
    }
}
