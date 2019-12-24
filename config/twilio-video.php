<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Twilio Keys
    |--------------------------------------------------------------------------
    |
    | The Twilio publishable key and secret key give you access to Twilio's
    | API.
    |
    */
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'api_key' => env('TWILIO_API_KEY'),
    'api_secret' => env('TWILIO_API_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Twilio Video Model
    |--------------------------------------------------------------------------
    |
    | This is the model in your application that implements the Video trait
    | provided by Twilio Video. It will serve as the primary model you use while
    | interacting with Twilio Video related methods and so on.
    |
    */

    'model' => env('TWILIO_VIDEO_MODEL', App\User::class),

    /*
    |--------------------------------------------------------------------------
    | Stripe Logger
    |--------------------------------------------------------------------------
    |
    | This setting defines which logging channel will be used by the Stripe
    | library to write log messages. You are free to specify any of your
    | logging channels listed inside the "logging" configuration file.
    |
    */

    //'logger' => env('CASHIER_LOGGER'),

];
