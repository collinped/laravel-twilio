<?php

use Illuminate\Support\Facades\Route;

Route::post('webhook/twilio-video', 'TwilioVideoWebhookController@handleWebhook')->name('video.webhook');

Route::post('twilio-chat/generate', 'TwilioChatController@generate')->name('chat.generate');
