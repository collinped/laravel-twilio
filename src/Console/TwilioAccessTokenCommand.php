<?php

namespace Collinped\Twilio\Console;

use Collinped\Twilio\TwilioAccessToken;
use Illuminate\Console\Command;
use Twilio\Jwt\Grants\VideoGrant;

class TwilioAccessTokenCommand extends Command
{
    /**
     * The console command name.
     */
    protected string $signature = 'twilio:token';

    /**
     * The console command description.
     */
    protected string $description = 'Twilio command to create a new access token.';

    protected TwilioAccessToken $twilioAccessToken;

    /**
     * Create a new command instance.
     */
    public function __construct(TwilioAccessToken $twilioAccessToken)
    {
        parent::__construct();

        $this->twilioAccessToken = $twilioAccessToken;
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $accessToken = $this->twilioAccessToken->getAccessToken();

        if ($this->confirm('Do you wish to add a grant to this token?')) {
            $grant = $this->choice(
                'What kind of grant would you like to add?',
                ['Video']
            );
            $grantFunctionName = 'add'.$grant.'Grant';
            $videoGrant = $this->$grantFunctionName();
            $accessToken->addGrant($videoGrant);
        }

        $this->line('Twilio Access Token:');
        $this->info($accessToken->toJWT());
    }

    /**
     * Proxy method for Laravel 5.1+
     */
    public function handle()
    {
        return $this->fire();
    }

    protected function addVideoGrant()
    {
        $roomName = $this->ask('What is the name of the video room?');
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);

        return $videoGrant;
    }
}
