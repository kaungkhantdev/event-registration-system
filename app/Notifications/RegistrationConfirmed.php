<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationConfirmed extends Notification
{
    use Queueable;

    public function __construct(
        private Registration $registration
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $event = $this->registration->event;

        return (new MailMessage)
            ->subject('Registration Confirmed - ' . $event->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your registration for **' . $event->title . '** has been confirmed.')
            ->line('**Event Details:**')
            ->line('Date: ' . $event->event_date->format('F j, Y g:i A'))
            ->line('Location: ' . $event->location)
            ->line('Amount Paid: $' . number_format($this->registration->amount_paid, 2))
            ->action('View Event Details', route('events.show', $event->id))
            ->line('We look forward to seeing you at the event!');
    }
}
