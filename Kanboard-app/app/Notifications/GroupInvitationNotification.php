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
        $name = is_object($notifiable) && property_exists($notifiable, 'name') ? $notifiable->name : 'cher utilisateur';
    
        return (new MailMessage)
        ->subject("Invitation à collaborer sur le tableau {$this->board->name}")
        ->greeting("Salut {$name} !")
        ->line("Vous êtes invité(e) à participer au tableau : {$this->board->name}.")
        ->action('Rejoindre le projet', route('invitations.accept', $this->token))
        ->line('Si ce message ne vous concerne pas, vous pouvez l’ignorer.')
        ->salutation("L’équipe BoardTech");
    }
    
}