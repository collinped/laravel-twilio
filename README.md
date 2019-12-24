laravel-twilio
===============
Laravel Twilio Video API Integration

## Installation

Begin by installing this package through Composer. Run this command from the Terminal:

```bash
composer require collinped/twilio-video
```
If you're using Laravel 5.5+, this is all there is to do.

Should you still be on older versions of Laravel, the final steps for you are to add the service provider of the package and alias the package. To do this open your `config/app.php` file.

## Integration for older versions of Laravel (5.5 -)

To wire this up in your Laravel project, you need to add the service provider.
Open `app.php`, and add a new item to the providers array.

```php
'Collinped\TwilioVideo\TwilioVideoServiceProvider',
```

This will register a new artisan command for you:

- `twilio-video:room`
