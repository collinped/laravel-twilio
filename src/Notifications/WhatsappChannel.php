<?php

namespace Collinped\Twilio\Notifications;

use Illuminate\Notifications\Notification;

class WhatsappChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        return $notification->toWhatsApp($notifiable);
    }
}
