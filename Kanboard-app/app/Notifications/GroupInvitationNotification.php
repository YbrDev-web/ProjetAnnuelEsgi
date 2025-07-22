<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Board;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;


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
        $isRegisteredUser = isset($notifiable->name);
        $name = $isRegisteredUser ? $notifiable->name : 'utilisateur';
        $greeting = $isRegisteredUser ? "Salut {$name} !" : "Bonjour cher utilisateur";
    
        // ✅ Lien signé valable 2 minutes
        $signedUrl = URL::temporarySignedRoute(
            'invitations.accept',           // nom de la route
            Carbon::now()->addMinutes(2),   // lien expirera dans 2 minutes
            ['token' => $this->token]
        );
    
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject("Invitation à rejoindre le tableau « {$this->board->name} »")
            ->greeting($greeting)
            ->line("Vous avez été invité à rejoindre le tableau « {$this->board->name} ».")
            ->action("Accepter l’invitation", $signedUrl)
            ->line("⚠️ Ce lien expirera dans 2 minutes.")
            ->line("Si vous ne reconnaissez pas cette invitation, ignorez ce message.")
            ->salutation("L’équipe BoardTech");
    }

    
}