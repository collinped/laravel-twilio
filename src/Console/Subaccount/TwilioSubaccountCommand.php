<?php
namespace Collinped\Twilio\Console\Subaccount;

use Collinped\Twilio\Twilio;
use Illuminate\Console\Command;

class TwilioSubaccountCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'twilio:subaccount:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Twilio command to create a new subaccount.';

    /**
     * @var \Collinped\Twilio\Twilio
     */
    protected Twilio $twilio;

    /**
     * Create a new command instance.
     * @param Twilio $twilio
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
        $subaccountName = $this->ask('What is the name for this subaccount?');

        $subaccount = $this->twilio->subAccount()->create($subaccountName);

        $this->line('Successfully created subaccount with SID: ' . $subaccount->sid);
    }

    /**
     * Proxy method for Laravel 5.1+
     */
    public function handle()
    {
        return $this->fire();
    }
}
