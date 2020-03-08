<?php

use Illuminate\Support\Facades\Route;

Route::post('webhook/twilio-video', 'TwilioVideoWebhookController@handleWebhook')->name('video.webhook');
Route::post('webhook/twilio-sms', 'TwilioSmsWebhookController@handleWebhook')->name('sms.webhook');

Route::post('twilio-chat/generate', 'TwilioChatController@generate')->name('chat.generate');
