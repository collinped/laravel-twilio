<?php

namespace Collinped\Twilio\Console;

use Collinped\Twilio\Twilio;
use Illuminate\Console\Command;

class TwilioVoiceVerifyCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'twilio:voice:verify
                            {number? : The phone number to verify}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Twilio command to verify an outgoing phone number.';

    /**
     * @var \Collinped\Twilio\Twilio
     */
    protected $twilio;

    /**
     * Create a new command instance.
     *
     * @param  Twilio  $twilio
     */
    public function __construct(Twilio $twilio)
    {
        parent::__construct();
        $this->twilio = $twilio;
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        if (! $this->argument('number')) {
            $phoneNumber = $this->ask('What phone number would you like to verify?');
        } else {
            $phoneNumber = $this->argument('number');
        }

        $friendlyName = $this->ask('What is the friendly name for this number?');

        $validationRequest = $this->twilio->sdk()->validationRequests
            ->create(
                $phoneNumber,
                ['friendlyName' => $friendlyName]
            );

        dd($validationRequest);
    }

    /**
     * Proxy method for Laravel 5.1+
     */
    public function handle()
    {
        return $this->fire();
    }
}
