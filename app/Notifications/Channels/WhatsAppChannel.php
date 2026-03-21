<?php

namespace App\Notifications\Channels;

use App\Services\WhatsAppService;
use Illuminate\Notifications\Notification;

class WhatsAppChannel
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function send($notifiable, Notification $notification)
    {
        $messageData = $notification->toWhatsApp($notifiable);
        $phone = $notifiable->routeNotificationFor('whatsapp', $notification);

        if (!$phone || !$messageData) {
            return;
        }

        if (is_array($messageData)) {
            return $this->whatsapp->sendTemplateMessage($phone, $messageData);
        }

        return $this->whatsapp->sendMessage($phone, $messageData);
    }
}
