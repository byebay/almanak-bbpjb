<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomPasswordReset extends Notification
{
    use Queueable;

    public $token;
    public $userEmail;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token, string $userEmail)
    {
        $this->token = $token;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $this->userEmail,
        ]);

        return (new MailMessage)
            ->subject('Permintaan Atur Ulang Kata Sandi')
            ->view('emails.password-reset', [
                'url' => $url,
                'appName' => config('app.name'),
            ]);
    }
}
