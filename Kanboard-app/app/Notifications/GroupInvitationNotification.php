<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Board;

class GroupInvitationNotification extends Notification
{
    use Queueable;

    public $board;
    public $token;

    public function __construct(Board $board, string $token)
    {
        $this->board = $board;
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Invitation à rejoindre un groupe')
            ->greeting("Bonjour {$notifiable->name}")
            ->line("Vous avez été invité à rejoindre le tableau « {$this->board->name} ».")
            ->action('Accepter l’invitation', url("/invitations/accept/{$this->token}"))
            ->line('Si vous ne reconnaissez pas cette invitation, ignorez ce message.');
    }
}