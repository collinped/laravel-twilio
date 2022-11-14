<?php

namespace Collinped\Twilio\Http\Controllers;

use Collinped\Twilio\Traits\TwilioWebhookTrait;
use Illuminate\Routing\Controller;

/**
 * Class TwilioVideoRoomCallback
 */
class TwilioPayWebhookController extends Controller
{
    use TwilioWebhookTrait;
}
