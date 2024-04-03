<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ConvocationInvitationNotification extends Notification
{
    protected $title;
    protected $message;

    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
//        dd($this->title, $this->message);
        return (new WebPushMessage)
            ->title($this->title)
            ->icon('https://cbsc-app.doryanbessiere.fr/logo192.png')
            ->body($this->message)
            ->action('Voir la convocation', 'https://cbsc-app.doryanbessiere.fr/')
            ->options(['TTL' => 1000])
            ->data([
                'title' => $this->title,
                'message' => $this->message,
            ]);
        ;
    }
}
