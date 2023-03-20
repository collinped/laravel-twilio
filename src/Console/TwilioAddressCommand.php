<?php

namespace Collinped\Twilio\Console;

use Collinped\Twilio\Twilio;
use Illuminate\Console\Command;

class TwilioAddressCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'twilio:address';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Twilio command to add a new address.';

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
        $addressName = $this->ask('What is the name for this address?');
        $street = $this->ask('What is the street for this address?');
        $city = $this->ask('What is the city for this address?');
        $region = $this->ask('What is the region for this address?');
        $postalCode = $this->ask('What is the postal code for this address?');
        $country = $this->anticipate('What is country for this address?', ['US']);

        $this->line('Name: '.$addressName);
        $this->line('Address: '.$street.' '.$city.', '.$region.' '.$postalCode);
        $this->line('Country: '.$country);

        if ($this->confirm('Is this information correct?')) {
            $address = $this->twilio->sdk()->addresses
                ->create($addressName,
                    $street, // street
                    $city, // city
                    $region, // region
                    $postalCode, // postalCode
                    $country // isoCountry
                );

            $this->info('Address SID: '.$address->sid);
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
