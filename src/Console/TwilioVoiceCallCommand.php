<?php
namespace Collinped\Twilio\Console;

use Collinped\Twilio\TwilioVoice;
use Illuminate\Console\Command;

class TwilioVoiceCallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'twilio:call
                       {to : Phone number to call}
                       {from? : Twilio number to call from}
                       {message? : The content of the voice message}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Twilio command to test Twilio Call API Integration.';

    /**
     * @var TwilioVoice
     */
    protected $twilioVoice;

    /**
     * Create a new command instance.
     *
     */
    public function __construct(TwilioVoice $twilioVoice)
    {
        parent::__construct();

        $this->twilioVoice = $twilioVoice;
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->line('Creating a call via Twilio to: '.$this->argument('phone'));

        // Grab options
        $from = $this->option('from');
        $url = $this->option('url');

        // Set a default URL if we havent specified one since is mandatory.
        if (is_null($url)) {
            $url = 'http://demo.twilio.com/docs/voice.xml';
        }

        $this->twilioVoice->call($this->argument('phone'), $url, [], $from);
    }

    /**
     * Proxy method for Laravel 5.1+
     */
    public function handle()
    {
        return $this->fire();
    }
}
