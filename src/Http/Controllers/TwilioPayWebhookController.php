<?php

namespace Collinped\Twilio\Http\Controllers;

use Collinped\Twilio\Traits\TwilioWebhookTrait;
use Illuminate\Routing\Controller;

/**
 * Class TwilioPayWebhookController
 */
class TwilioPayWebhookController extends Controller
{
    use TwilioWebhookTrait;
}
