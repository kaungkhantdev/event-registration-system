<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        private Registration $registration,
        private string $status
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $event = $this->registration->event;
        
        $message = (new MailMessage)
            ->subject('Registration Status Update - ' . $event->title)
            ->greeting('Hello ' . $notifiable->name . '!');

        if ($this->status === 'approved') {
            $message
                ->line('Great news! Your registration for **' . $event->title . '** has been approved.')
                ->line('**Event Details:**')
                ->line('Date: ' . $event->event_date->format('F j, Y g:i A'))
                ->line('Location: ' . $event->location)
                ->action('View Event Details', route('events.show', $event->id))
                ->line('We look forward to seeing you at the event!');
        } else {
            $message
                ->line('We regret to inform you that your registration for **' . $event->title . '** has been ' . $this->status . '.')
                ->line('If you have any questions, please contact us.')
                ->action('Browse Other Events', route('events.index'));
        }

        return $message;
    }
}
