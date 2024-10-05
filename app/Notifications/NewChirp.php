<?php

namespace App\Notifications;

use App\Models\Chirp;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewChirp extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Chirp $chirp)
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
        $userName = $this->chirp->user->name;

        $chirpMessage = Str::limit($this->chirp->message, 50);

        $actionUrl = url('/');

        $subject = "New Chirp from {$userName}";

        $greeting = "New Chirp from {$userName}";

        $thankYouMessage = 'Thank you for using our application!';

        $mailMessage = new MailMessage();

        return $mailMessage->subject($subject)
            ->greeting($greeting)
            ->line($chirpMessage)
            ->action('Navigate to Chirper', $actionUrl)
            ->line($thankYouMessage);
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
