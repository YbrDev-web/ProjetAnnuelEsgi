<?php

namespace App\Notifications;

use App\Models\Board;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GroupInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $board;
    public $token;

    /**
     * Crée une nouvelle instance.
     */
    public function __construct(Board $board, $token)
    {
        $this->board = $board;
        $this->token = $token;
    }

    /**
     * Détermine les canaux via lesquels la notification est envoyée.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Crée le contenu du mail.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Invitation à rejoindre un groupe')
            ->greeting('Bonjour ' . $notifiable->name . ' 👋')
            ->line("Vous avez été invité à rejoindre le tableau « {$this->board->name} ».")
            ->action('Accepter l’invitation', url("/invitations/accept/{$this->token}"))
            ->line('Si vous ne reconnaissez pas cette invitation, ignorez ce message.');
    }
}
