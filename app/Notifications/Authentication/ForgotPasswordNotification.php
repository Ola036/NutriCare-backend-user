<?php

namespace App\Notifications\Authentication;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForgotPasswordNotification extends Notification
{
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
            ->subject('Reset Password!')
            ->greeting("Dear {$notifiable->name},")
            ->line('Below you can find the code to reset your password:')
            ->line('Code: **' . $notifiable->reset_code . '**');
    }
}
