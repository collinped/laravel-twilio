<?php
namespace Aloha\Twilio\Commands;

use Collinped\Twilio\TwilioSms;
use Illuminate\Console\Command;

class TwilioSmsSendCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'twilio:sms
                            {to : Phone number to send the SMS message to}
                            {from? : Twilio number to send the SMS message from}
                            {message? : The content of the message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Twilio command to test Twilio SMS API Integration.';

    /**
     * @var \Collinped\Twilio\TwilioSms
     */
    protected $twilioSms;

    /**
     * Create a new command instance.
     *
     */
    public function __construct(TwilioSms $twilioSms)
    {
        parent::__construct();
        $this->twilioSms = $twilioSms;
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $fromTwilioNumber = ($this->argument('from') ?? config('twilio.sms.from'));

        $this->line('Sending SMS via Twilio to: '.$this->argument('to'). ' from: ' . $fromTwilioNumber);

        // Grab the text option if specified
        $message = $this->argument('message');

        // If we havent specified a message, setup a default one
        if (is_null($message)) {
            $message = 'This is a test message sent from the artisan console';
        }

        $this->line($message);

        $this->twilioSms
            ->to($this->argument('to'))
            ->from($fromTwilioNumber)
            ->message($message)
            ->send();
    }

    /**
     * Proxy method for Laravel 5.1+
     */
    public function handle()
    {
        return $this->fire();
    }
}
