<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Access Token
    |--------------------------------------------------------------------------
    |
    | Access token that can be found in your Twilio dashboard
    |
    */
    'auth_token' => env('TWILIO_AUTH_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | SID
    |--------------------------------------------------------------------------
    |
    | Your Twilio Account SID #
    |
    */
    'account_sid' => env('TWILIO_ACCOUNT_SID'),

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Your Twilio API Key
    |
    */
    'api_key' => env('TWILIO_API_KEY_SID'),

    /*
    |--------------------------------------------------------------------------
    | API Secret
    |--------------------------------------------------------------------------
    |
    | Your Twilio API Secret
    |
    */
    'api_secret' => env('TWILIO_API_KEY_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Disable Webhook Validation
    |--------------------------------------------------------------------------
    |
    | Disable the Twilio webhook validation middleware.
    |
    */
    'disable_webhook_validation' => env('TWILIO_DISABLE_WEBHOOK_VALIDATION', false),

    /*
    |--------------------------------------------------------------------------
    | Prefix to URL
    |--------------------------------------------------------------------------
    |
    | Add a prefix to the routes for the twilio prefixes
    | Example: {prefix}/webhook/voice
    |
    */
    'path' => env('TWILIO_PATH_PREFIX', 'twilio'),

    /*
    |--------------------------------------------------------------------------
    | Default Twilio From Number
    |--------------------------------------------------------------------------
    |
    | This will apply to all services that do not have a specified env variable
    |
    */
    'from' => env('TWILIO_FROM'),

    /*
    |--------------------------------------------------------------------------
    | Twilio Video Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration variables dedicated to Twilio Video
    |
    */
    'video' => [
        /*
        |--------------------------------------------------------------------------
        | Default Room Type
        |--------------------------------------------------------------------------
        |
        | The default video room type that will be created
        |
        */
        'room_type' => env('TWILIO_VIDEO_DEFAULT_ROOM_TYPE', 'peer-to-peer'),

        /*
        |--------------------------------------------------------------------------
        | Default Twilio Video Webhook/Callback URL
        |--------------------------------------------------------------------------
        |
        | The default callback URL that will be used
        |
        */
        //'webhook' => env('TWILIO_VIDEO_WEBHOOK', (\Route::has('twilio.video.webhook') ? route('twilio.video.webhook', null, false) : null))
        'webhook' => env('TWILIO_VIDEO_WEBHOOK', 'webhook/video'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Twilio SMS Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration variables dedicated to Twilio SMS
    |
    */
    'sms' => [
        'from' => env('TWILIO_SMS_FROM') ?? config('twilio.from'),
        /*
        |--------------------------------------------------------------------------
        | Default Twilio SMS Webhook/Callback URL
        |--------------------------------------------------------------------------
        |
        | The default callback URL that will be used
        |
        */
        //'webhook' => env('TWILIO_SMS_WEBHOOK', (\Route::has('twilio.sms.webhook') ? route('twilio.sms.webhook', null, false) : null))
        'webhook' => 'webhook/sms',
    ],

    /*
    |--------------------------------------------------------------------------
    | Twilio Video Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration variables dedicated to Twilio Voice
    |
    */
    'voice' => [
        'from' => env('TWILIO_VOICE_FROM') ?? config('twilio.from'),

        /*
        |--------------------------------------------------------------------------
        | Default Twilio Voice Webhook/Callback URL
        |--------------------------------------------------------------------------
        |
        | The default callback URL that will be used
        |
        */
        //'webhook' => env('TWILIO_VOICE_WEBHOOK', (\Route::has('twilio.voice.webhook') ? route('twilio.voice.webhook', null, false) : null ))
        'webhook' => 'webhook/voice',
    ],

    'fax' => [
        'from' => env('TWILIO_FAX_FROM') ?? config('twilio.from'),

        /*
        |--------------------------------------------------------------------------
        | Default Twilio Voice Webhook/Callback URL
        |--------------------------------------------------------------------------
        |
        | The default callback URL that will be used
        |
        */
        //'webhook' => env('TWILIO_FAX_WEBHOOK', (\Route::has('twilio.fax.webhook') ? route('twilio.fax.webhook', null, false) : null ))
        'webhook' => 'webhook/twilio-fax',
    ],

    /*
    |--------------------------------------------------------------------------
    | Twilio Verify Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration variables dedicated to Twilio Verify
    |
    */
    'verify' => [],

    /*
    |--------------------------------------------------------------------------
    | Twilio Chat Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration variables dedicated to Twilio Chat
    |
    */
    'chat' => [],
];
