<?php

namespace Collinped\Twilio\Console;

use Collinped\Twilio\Twilio;
use Illuminate\Console\Command;

class TwilioBuyPhoneNumberCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'twilio:buy
                            {number? : The phone number to purchase}
                            {--areacode= : The area code for the a local phone number}
                            {--country=US : The region to search for phone numbers}
                            {--address= : The address SID for the the phone number}
                            {--local : Local Phone Number}
                            {--toll : Toll Free Number}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Twilio command to purchase a new phone number.';

    /**
     * @var \Collinped\Twilio\Twilio
     */
    protected $twilio;

    /**
     * Create a new command instance.
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
        $country = $this->option('country');

        if (! $this->argument('number')) {
            if ($this->option('local') || $this->option('areacode')) {
                $attributes = [];
                if ($this->option('areacode')) {
                    $attributes['areaCode'] = $this->option('areacode');
                }
                $twilioPhoneNumbers = $this->twilio->phoneNumber()
                    ->region($country)
                    ->search($attributes);
            } else {
                $twilioPhoneNumbers = $this->twilio->phoneNumber()
                    ->region($country)
                    ->tollFree()
                    ->search();
            }

            $twilioPhoneNumbers = collect($twilioPhoneNumbers);

            $availableNumbers = [];
            foreach ($twilioPhoneNumbers as $twilioPhoneNumber) {
                array_push($availableNumbers, $twilioPhoneNumber->phoneNumber);
            }

            $selectedPhoneNumber = $this->choice(
                'What phone number would you like to buy?',
                $availableNumbers
            );
        } else {
            $selectedPhoneNumber = $this->argument('number');
        }

        $phoneNumberAttributes = [
            'phoneNumber' => $selectedPhoneNumber,
        ];

        if ($this->confirm('Would you like to create a Regulatory Bundle? (Can take up to 3 days)')) {
            //TODO add the option to create a new address on the fly
            $twilioAddresses = $this->twilio->sdk()->addresses
                ->read([], 20);

            //TODO if there are no addresses force create a new address
            if (empty($twilioAddresses)) {
                $this->info('Empty addresses');
            }
            $addressSid = $this->ask('What is the Address SID for this phone number?');

            //$twilioAddressSids = collect($twilioAddresses);
            //dd($twilioAddressSids);
            //$address = $this->choice('Which address would you like to assign to this phone number?', $twilioAddresses);

            $phoneNumberAttributes['addressSid'] = '';
            $phoneNumberAttributes['bundleSid'] = '';
        }

        if ($this->confirm('Would you like to purchase '.$selectedPhoneNumber.'?')) {
            $puchasedPhoneNumber = $this->twilio->sdk()->incomingPhoneNumbers
                ->create($phoneNumberAttributes);

            $this->info('Successfully purchased phone number: '.$selectedPhoneNumber);
        }
    }

    /**
     * Proxy method for Laravel 5.1+
     */
    public function handle()
    {
        return $this->fire();
    }
}
