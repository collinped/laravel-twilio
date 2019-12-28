<?php

namespace Collinped\Twilio\Http\Controllers;

use App\Http\Controllers\Controller;
use Collinped\Twilio\TwilioWebhook;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TwilioVideoRoomCallback
 * @package App\Http\Controllers\Callback
 */
class TwilioVoiceWebhookController extends Controller
{
    use TwilioWebhook;
}
