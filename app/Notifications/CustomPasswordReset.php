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
            ->greeting('Halo!')
            ->line('Anda menerima posel ini karena kami menerima permintaan ganti kata sandi untuk akun Anda.')
            ->action('Ganti Kata Sandi', $url)
            ->line('Tautan ganti kata sandi ini berlaku selama 60 menit.')
            ->line('Jika Anda tidak merasa melakukan permintaan ini, abaikan posel ini.');
    }
}
