<?php

namespace App\Notifications\Authentication;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
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
        $notifiable->reset_code = rand(111111, 999999);
        $notifiable->save();

        return (new MailMessage)
            ->subject('Email Verification')
            ->greeting("Dear {$notifiable->name},")
            ->line('Below you can find the code to verify your account:')
            ->line('Code: **' . $notifiable->reset_code . '**');
    }
}
