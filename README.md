![Laravel Twilio](cover.png?raw=true "Laravel Twilio")

laravel-twilio
===============
UNDER CONSTRUCTION - Laravel Twilio SDK/API Integration

## Installation

Begin by installing this package through Composer. Run this command from the Terminal:

```bash
composer require collinped/laravel-twilio
```
If you're using Laravel 5.5+, this is all there is to do.

Should you still be on older versions of Laravel, the final steps for you are to add the service provider of the package and alias the package. To do this open your `config/app.php` file.

### Integration for older versions of Laravel (5.5 -)

To wire this up in your Laravel project, you need to add the service provider.
Open `app.php`, and add a new item to the providers array.

```php
'Collinped\Twilio\TwilioServiceProvider',
```

This will register a new artisan command for you:

- `twilio:video-room NAME`
- `twilio:video-participants SID`


### Configuring the package

You can publish the config file with:

```php
php artisan vendor:publish --provider="Collinped\Twilio\TwilioServiceProvider" --tag="config"
```

This is the contents of the file that will be published at config/twilio.php

Insert the following values into your .env

```php
TWILIO_AUTH_TOKEN=
TWILIO_ACCOUNT_SID=
TWILIO_API_KEY=
TWILIO_API_SECRET=
```

See Twilio Settings for instructions on how to get these values.

### Taking care of routing

Finally, let's take care of the routing. At the app that sends webhooks, you probably configure an URL where you want your webhook requests to be sent. In the routes file of your app (web.php), you must pass that route to `Route::post` or `Route::get` depending on your specified method. Here's an example:

```php
Route::post('webhook/twilio-video', 'TwilioVideoWebhookController@handleWebhook')->name('twilio.video.webhook');
Route::post('webhook/twilio-voice', 'TwilioVoiceWebhookController@handleWebhook')->name('twilio.voice.webhook');
Route::post('webhook/twilio-sms', 'TwilioSmsWebhookController@handleWebhook')->name('twilio.sms.webhook');
Route::post('webhook/twilio-fax', 'TwilioFaxWebhookController@handleWebhook')->name('twilio.fax.webhook');
```

Behind the scenes, this will register a `POST` or `GET` route to a controller provided by this package. Because the app that sends webhooks to you has no way of getting a csrf-token, you must add that route to the `except` array of the `VerifyCsrfToken` middleware:

```php
protected $except = [
    'webhook/twilio/*', // All Twilio Webhooks
];
```

Or whitelist each endpoint individually based on your application

```php
protected $except = [
    'webhook/twilio/video', // Twilio Video Webhooks
    'webhook/twilio/voice', // Twilio Voice Webhooks
    'webhook/twilio/voice-recording', // Twilio Voice Recording Webhooks
    'webhook/twilio/sms', // Twilio SMS Webhooks
    'webhook/twilio/conversations', // Twilio Conversations Webhooks
];
```

### Twilio Video Settings

If you have an existing Twilio account login to your console or sign up here for your free trial account: <a href="https://www.twilio.com/referral/ghFcTs" target="_blank">Register for Twilio</a>

- Navigate to "Programmable Video"
- Navigate to "Rooms"
- Navigate to "Settings"
- Set the method as "HTTP POST"
- Input your "Status Callback URL" as:

```
yourdomain.com/webhook/twilio/video
```

### Laravel Twilio Roadmap

- [x] Twilio Voice
- [x] Twilio SMS
- [x] Twilio Video
- [ ] Twilio Phone Numbers
- [ ] Twilio Short Codes
- [ ] Twilio Conversations
- [x] Twilio Verify
- [ ] Twilio Verify Email - Sendgrid
- [ ] Twilio Programmable Wireless
- [ ] Twilio Proxy
- [ ] Twilio Lookup
- [ ] Twilio Flex
- [ ] Twilio Assistant

### License

laravel-twilio is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
