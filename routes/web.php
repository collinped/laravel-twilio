<?php

use Illuminate\Support\Facades\Route;

Route::post('webhook/twilio-video', 'VideoWebhookController@handleWebhook')->name('video.webhook');
