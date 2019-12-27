![Laravel Twilio Video](cover.png?raw=true "Laravel Twilio Video")

laravel-twilio-video
===============
UNDER CONSTRUCTION - Laravel Twilio Video API Integration

## Installation

Begin by installing this package through Composer. Run this command from the Terminal:

```bash
composer require collinped/laravel-twilio-video
```
If you're using Laravel 5.5+, this is all there is to do.

Should you still be on older versions of Laravel, the final steps for you are to add the service provider of the package and alias the package. To do this open your `config/app.php` file.

### Integration for older versions of Laravel (5.5 -)

To wire this up in your Laravel project, you need to add the service provider.
Open `app.php`, and add a new item to the providers array.

```php
'Collinped\TwilioVideo\TwilioVideoServiceProvider',
```

This will register a new artisan command for you:

- `twilio-video:room NAME`
- `twilio-video:participants SID`


### Configuring the package

You can publish the config file with:

```php
php artisan vendor:publish --provider="Collinped\TwilioVideo\TwilioVideoServiceProvider" --tag="config"
```

This is the contents of the file that will be published at config/twilio-video.php

Insert the following values into your .env

```php
TWILIO_AUTH_TOKEN=
TWILIO_ACCOUNT_SID=
TWILIO_API_KEY=
TWILIO_API_SECRET=
```

See Twilio Video Settings for instructions on how to get these values.

### Taking care of routing

Finally, let's take care of the routing. At the app that sends webhooks, you probably configure an URL where you want your webhook requests to be sent. In the routes file of your app (web.php), you must pass that route to `Route::post`. Here's an example:

```php
Route::post('webhook/twilio-video', 'WebhookController@handleWebhook')->name('twilio-video.webhook');
```

Behind the scenes, this will register a `POST` route to a controller provided by this package. Because the app that sends webhooks to you has no way of getting a csrf-token, you must add that route to the `except` array of the `VerifyCsrfToken` middleware:

```php
protected $except = [
    'webhook/twilio-video',
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
yourdomain.com/webhook/twilio-video
```

### License

laravel-twilio-video is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
