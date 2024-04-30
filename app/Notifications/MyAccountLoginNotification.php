<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MyAccountLoginNotification extends Notification
{
    use Queueable;

    protected $email;
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Connexion à votre compte du Club Bouliste Saint-Couatais")
                    ->line("Bienvenue sur l'application officiel du Club Bouliste Saint-Couatais. Voici vos informations de connexion :")
                    ->line("Email : {$this->email}")
                    ->line("Mot de passe : {$this->password}")
                    ->action("Se connecter sur l'application", url('https://cbsc-app.doryanbessiere.fr/'))
                    ->line('Merci de votre confiance !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
