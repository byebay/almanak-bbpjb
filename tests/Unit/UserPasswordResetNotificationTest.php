<?php

namespace Tests\Unit;

use App\Models\User;
use App\Notifications\CustomPasswordReset;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserPasswordResetNotificationTest extends TestCase
{
    public function test_send_password_reset_notification_uses_custom_indonesian_notification(): void
    {
        Notification::fake();

        $user = new User([
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);

        $user->sendPasswordResetNotification('token-123');

        Notification::assertSentTo($user, CustomPasswordReset::class, function ($notification, $channels) use ($user) {
            $mailMessage = $notification->toMail($user);

            $this->assertSame('Permintaan Atur Ulang Kata Sandi', $mailMessage->subject);
            $this->assertStringContainsString('Anda menerima pesan ini', $mailMessage->render());
            $this->assertStringContainsString('Ganti Kata Sandi', $mailMessage->render());

            return true;
        });
    }
}
