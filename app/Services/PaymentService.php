<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Registration;
use App\Notifications\RegistrationConfirmed;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Exception;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create payment intent for registration
     */
    public function createPaymentIntent(Registration $registration): array
    {
        $event = $registration->event;
        
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $this->convertToStripeAmount($event->price),
                'currency' => 'usd',
                'metadata' => [
                    'registration_id' => $registration->id,
                    'event_id' => $event->id,
                    'user_id' => $registration->user_id,
                ],
                'description' => "Registration for {$event->title}",
            ]);

            // Store payment record
            Payment::create([
                'user_id' => $registration->user_id,
                'registration_id' => $registration->id,
                'stripe_payment_intent_id' => $paymentIntent->id,
                'amount' => $event->price,
                'currency' => 'usd',
                'status' => 'pending',
                'metadata' => json_encode([
                    'event_title' => $event->title,
                    'event_date' => $event->event_date,
                ]),
            ]);

            return [
                'client_secret' => $paymentIntent->client_secret,
                'payment_intent_id' => $paymentIntent->id,
            ];
        } catch (Exception $e) {
            throw new Exception("Failed to create payment intent: " . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     */
    public function handleSuccessfulPayment(string $paymentIntentId): void
    {
        DB::transaction(function () use ($paymentIntentId) {
            $payment = Payment::where('stripe_payment_intent_id', $paymentIntentId)->firstOrFail();
            
            // Update payment status
            $payment->update(['status' => 'succeeded']);
            
            // Update registration
            $registration = $payment->registration;
            $registration->update([
                'status' => 'approved',
                'payment_id' => $paymentIntentId,
                'payment_status' => 'succeeded',
            ]);
            
            // Send confirmation notification
            $registration->user->notify(new RegistrationConfirmed($registration));
        });
    }

    /**
     * Handle failed payment
     */
    public function handleFailedPayment(string $paymentIntentId): void
    {
        $payment = Payment::where('stripe_payment_intent_id', $paymentIntentId)->firstOrFail();
        
        $payment->update(['status' => 'failed']);
        
        $payment->registration->update([
            'payment_status' => 'failed',
        ]);
    }

    /**
     * Refund payment
     */
    public function refundPayment(Payment $payment): bool
    {
        try {
            if ($payment->status !== 'succeeded') {
                throw new Exception('Cannot refund a payment that has not succeeded.');
            }

            $refund = Refund::create([
                'payment_intent' => $payment->stripe_payment_intent_id,
            ]);

            $payment->update(['status' => 'refunded']);
            
            $payment->registration->update([
                'payment_status' => 'refunded',
            ]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Failed to refund payment: " . $e->getMessage());
        }
    }

    /**
     * Convert amount to Stripe format (cents)
     */
    private function convertToStripeAmount(float $amount): int
    {
        return (int) ($amount * 100);
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        try {
            \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                config('services.stripe.webhook_secret')
            );
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
