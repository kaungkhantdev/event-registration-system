<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\Notifications\RegistrationConfirmed;
use App\Notifications\RegistrationStatusUpdated;
use Illuminate\Support\Facades\DB;
use Exception;

class RegistrationService
{
    public function __construct(
        private PaymentService $paymentService
    ) {}

    /**
     * Register user for an event
     */
    public function registerForEvent(User $user, Event $event): Registration
    {
        // Check if registration is open
        if (!$event->isRegistrationOpen()) {
            throw new Exception('Registration is closed for this event.');
        }

        // Check if user already registered
        if ($this->isUserRegistered($user, $event)) {
            throw new Exception('You are already registered for this event.');
        }

        return DB::transaction(function () use ($user, $event) {
            $registration = Registration::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'status' => $event->isFree() ? 'approved' : 'pending',
                'amount_paid' => $event->price,
                'registered_at' => now(),
            ]);

            // If event is free, auto-approve
            if ($event->isFree()) {
                $user->notify(new RegistrationConfirmed($registration));
            }

            return $registration;
        });
    }

    /**
     * Check if user is already registered
     */
    public function isUserRegistered(User $user, Event $event): bool
    {
        return Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();
    }

    /**
     * Get user's registrations
     */
    public function getUserRegistrations(User $user)
    {
        return Registration::with('event')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Approve registration
     */
    public function approveRegistration(Registration $registration): Registration
    {
        $registration->update(['status' => 'approved']);
        
        // Send notification
        $registration->user->notify(new RegistrationStatusUpdated($registration, 'approved'));
        
        return $registration->fresh();
    }

    /**
     * Reject registration
     */
    public function rejectRegistration(Registration $registration): Registration
    {
        DB::transaction(function () use ($registration) {
            $registration->update(['status' => 'rejected']);
            
            // Refund if payment was made
            if ($registration->payment_id && $registration->payment_status === 'succeeded') {
                $this->paymentService->refundPayment($registration->payment);
            }
            
            // Send notification
            $registration->user->notify(new RegistrationStatusUpdated($registration, 'rejected'));
        });
        
        return $registration->fresh();
    }

    /**
     * Cancel registration
     */
    public function cancelRegistration(Registration $registration): Registration
    {
        DB::transaction(function () use ($registration) {
            $registration->update(['status' => 'cancelled']);
            
            // Refund if payment was made and event hasn't started
            if ($registration->payment_id 
                && $registration->payment_status === 'succeeded'
                && $registration->event->event_date > now()) {
                $this->paymentService->refundPayment($registration->payment);
            }
        });
        
        return $registration->fresh();
    }

    /**
     * Get event attendees
     */
    public function getEventAttendees(Event $event)
    {
        return Registration::with('user')
            ->where('event_id', $event->id)
            ->where('status', 'approved')
            ->orderBy('registered_at', 'asc')
            ->get();
    }

    /**
     * Get pending registrations for event
     */
    public function getPendingRegistrations(Event $event)
    {
        return Registration::with('user')
            ->where('event_id', $event->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
