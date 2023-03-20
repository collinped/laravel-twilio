<?php

namespace Collinped\Twilio\Console;

use Collinped\Twilio\Twilio;
use Illuminate\Console\Command;

class TwilioVideoRoomCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'twilio:video
                      {name? : Name of the twilio video room}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Twilio command to create a Twilio Video Room.';

    protected $twilioVideo;

    /**
     * Create a new command instance.
     */
    public function __construct(Twilio $twilioVideo)
    {
        parent::__construct();

        $this->twilioVideo = $twilioVideo;
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        if ($this->argument('name')) {
            $videoRoomName = $this->argument('name');
        } else {
            $videoRoomName = $this->ask('What is the video room name?');
        }

        $this->line('Creating a room via Twilio Video with name: '.$videoRoomName);
    }

    /**
     * Proxy method for Laravel 5.1+
     */
    public function handle()
    {
        return $this->fire();
    }
}
