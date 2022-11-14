<?php

use Illuminate\Support\Facades\Route;

Route::post('/webhook/voice', 'TwilioVoiceWebhookController@handleWebhook')
    ->name('voice.webhook');

Route::post('/webhook/voice-recording', 'TwilioVoiceRecordingWebhookController@handleWebhook')
    ->name('voice-recording.webhook');

Route::post('/webhook/sms', 'TwilioSmsWebhookController@handleWebhook')
    ->name('sms.webhook');

Route::post('/webhook/conversations', 'TwilioConversationWebhookController@handleWebhook')
    ->name('conversation.webhook');

Route::post('/webhook/video', 'TwilioVideoWebhookController@handleWebhook')
    ->name('video.webhook');
