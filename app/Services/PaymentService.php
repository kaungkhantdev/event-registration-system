<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Registration;
use App\Notifications\RegistrationConfirmed;
use Stripe\Stripe;
use Stripe\Checkout\Session;
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
     * Create Stripe Checkout Session for registration
     */
    public function createCheckoutSession(Registration $registration): string
    {
        $event = $registration->event;

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $event->title,
                            'description' => "Event on {$event->event_date->format('F j, Y g:i A')} at {$event->location}",
                        ],
                        'unit_amount' => $this->convertToStripeAmount($event->price),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel'),
                'client_reference_id' => (string) $registration->id,
                'customer_email' => $registration->user->email,
                'metadata' => [
                    'registration_id' => $registration->id,
                    'event_id' => $event->id,
                    'user_id' => $registration->user_id,
                ],
            ]);

            // Store payment record with session ID
            Payment::create([
                'user_id' => $registration->user_id,
                'registration_id' => $registration->id,
                'stripe_payment_intent_id' => $session->id,
                'amount' => $event->price,
                'currency' => 'usd',
                'status' => 'pending',
                'metadata' => json_encode([
                    'event_title' => $event->title,
                    'event_date' => $event->event_date,
                    'session_id' => $session->id,
                ]),
            ]);

            return $session->url;
        } catch (Exception $e) {
            throw new Exception("Failed to create checkout session: " . $e->getMessage());
        }
    }

    /**
     * Handle successful payment from Checkout Session
     */
    public function handleSuccessfulPayment(string $sessionId): void
    {
        DB::transaction(function () use ($sessionId) {
            $payment = Payment::where('stripe_payment_intent_id', $sessionId)->firstOrFail();

            // Update payment status
            $payment->update(['status' => 'succeeded']);

            // Update registration
            $registration = $payment->registration;
            $registration->update([
                'status' => 'approved',
                'payment_id' => $sessionId,
                'payment_status' => 'succeeded',
            ]);

            // Send confirmation notification
            $registration->user->notify(new RegistrationConfirmed($registration));
        });
    }

    /**
     * Get checkout session details
     */
    public function getCheckoutSession(string $sessionId): ?array
    {
        try {
            $session = Session::retrieve($sessionId);
            return [
                'id' => $session->id,
                'payment_status' => $session->payment_status,
                'customer_email' => $session->customer_email,
                'metadata' => $session->metadata->toArray(),
            ];
        } catch (Exception $e) {
            return null;
        }
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

            $session = Session::retrieve($payment->stripe_payment_intent_id);
            $paymentIntentId = $session->payment_intent;

            $refund = Refund::create([
                'payment_intent' => $paymentIntentId,
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
     * Retry payment for failed/cancelled registration
     */
    public function retryPayment(Registration $registration): string
    {
        try {
            // Check if the registration can be retried
            if (!in_array($registration->payment_status, ['failed', 'pending', null])) {
                throw new Exception('Payment cannot be retried for this registration.');
            }

            // Create a new checkout session
            return $this->createCheckoutSession($registration);
        } catch (Exception $e) {
            throw new Exception("Failed to retry payment: " . $e->getMessage());
        }
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
