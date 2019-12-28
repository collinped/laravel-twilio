<?php
namespace Aloha\Twilio\Commands;

use Collinped\Twilio\TwilioSms;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TwilioSmsSendCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'twilio:sms';

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
        $this->line('Sending SMS via Twilio to: '.$this->argument('phone'));

        // Grab the text option if specified
        $text = $this->option('text');

        // If we havent specified a message, setup a default one
        if (is_null($text)) {
            $text = 'This is a test message sent from the artisan console';
        }

        $this->line($text);

        $this->twilioSms->message($this->argument('phone'), $text);
    }

    /**
     * Proxy method for Laravel 5.1+
     */
    public function handle()
    {
        return $this->fire();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['phone', InputArgument::REQUIRED, 'The phone number that will receive a test message.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['text', null, InputOption::VALUE_OPTIONAL, 'Optional message that will be sent.', null],
        ];
    }
}
