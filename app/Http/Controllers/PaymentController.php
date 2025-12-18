<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Exception;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {}

    /**
     * Handle payment success from Stripe Checkout
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('events.index')
                ->with('error', 'Payment information missing.');
        }

        try {
            // Verify the session belongs to the authenticated user
            $sessionData = $this->paymentService->getCheckoutSession($sessionId);

            if (!$sessionData) {
                return redirect()->route('events.index')
                    ->with('error', 'Invalid payment session.');
            }

            // Verify session belongs to current user
            if ($sessionData['metadata']['user_id'] != auth()->id()) {
                return redirect()->route('events.index')
                    ->with('error', 'Unauthorized access to payment.');
            }

            // Handle successful payment
            if ($sessionData['payment_status'] === 'paid') {
                $this->paymentService->handleSuccessfulPayment($sessionId);
            }

            return view('payments.success');
        } catch (Exception $e) {
            return redirect()->route('events.index')
                ->with('error', 'Failed to process payment confirmation.');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function cancel()
    {
        return view('payments.cancel');
    }

    /**
     * Retry payment for a failed registration
     */
    public function retry(int $registrationId)
    {
        try {
            $registration = auth()->user()->registrations()->findOrFail($registrationId);

            // Verify the event is still available
            if (!$registration->event) {
                return redirect()->route('registrations.index')
                    ->with('error', 'Event no longer exists.');
            }

            // Create new checkout session
            $checkoutUrl = $this->paymentService->retryPayment($registration);

            return redirect($checkoutUrl);
        } catch (Exception $e) {
            return redirect()->route('registrations.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Handle Stripe webhook
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        if (!$this->paymentService->verifyWebhookSignature($payload, $signature)) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $event = json_decode($payload);

        try {
            switch ($event->type) {
                case 'checkout.session.completed':
                    // Handle successful checkout session
                    $session = $event->data->object;
                    if ($session->payment_status === 'paid') {
                        $this->paymentService->handleSuccessfulPayment($session->id);
                    }
                    break;

                case 'checkout.session.expired':
                    // Handle expired checkout session
                    $session = $event->data->object;
                    $this->paymentService->handleFailedPayment($session->id);
                    break;
            }

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            \Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}
