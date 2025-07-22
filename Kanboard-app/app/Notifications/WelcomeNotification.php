<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Bienvenue sur ' . config('app.name'))
        ->greeting('Bonjour ' . $notifiable->name . ' 👋')
        ->line("Bienvenue sur notre application de gestion de projets ! 🎉")
        ->line("Nous sommes ravis de vous compter parmi nous.")
        ->action('Accéder au tableau de bord', url('/dashboard'))
        ->line("Si vous avez des questions, n'hésitez pas à nous contacter.")
        ->salutation('— L’équipe ' . config('app.name'));
}


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
