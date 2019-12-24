<?php
namespace Aloha\Twilio\Commands;

use Collinped\TwilioVideo\TwilioVideo;
use Collinped\TwilioVideo\TwilioVideoInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TwilioVideoRoomCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'twilio:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Twilio command to create a Twilio Video Room.';

    protected $twilio;

    /**
     * Create a new command instance.
     * @param TwilioVideo $twilioVideo
     */
    public function __construct(TwilioVideo $twilioVideo)
    {
        parent::__construct();

        $this->twilio = $twilioVideo->twilio();
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->line('Creating a room via Twilio Video with name: '.$this->argument('unique_name'));

//        // Grab options
//        $from = $this->option('from');
//        $url = $this->option('url');
//
//        // Set a default URL if we havent specified one since is mandatory.
//        if (is_null($url)) {
//            $url = 'http://demo.twilio.com/docs/voice.xml';
//        }
//
//        $this->twilio->call($this->argument('phone'), $url, [], $from);
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
            ['unique_name', InputArgument::REQUIRED, 'The phone number that will receive a test message.'],
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
            ['url', null, InputOption::VALUE_OPTIONAL, 'Optional url that will be used to fetch xml for call.', null],
            ['from', null, InputOption::VALUE_OPTIONAL, 'Optional from number that will be used.', null],
        ];
    }
}
