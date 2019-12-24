<?php

use Illuminate\Support\Facades\Route;

Route::post('webhook/twilio-video', 'WebhookController@handleWebhook')->name('webhook');
