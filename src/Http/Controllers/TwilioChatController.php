<?php

namespace Collinped\Twilio\Http\Controllers;

use App\Http\Controllers\Controller;
use Collinped\Twilio\TwilioChat;
use Collinped\Twilio\TwilioWebhook;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TwilioVideoRoomCallback
 * @package App\Http\Controllers\Callback
 */
class TwilioChatController extends Controller
{
    public function generate(Request $request)
    {
        TwilioChat::generate();
    }
}
