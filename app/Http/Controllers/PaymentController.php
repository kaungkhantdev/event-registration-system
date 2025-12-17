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
     * Handle payment success
     */
    public function success(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');
        
        if (!$paymentIntentId) {
            return redirect()->route('events.index')
                ->with('error', 'Payment information missing.');
        }

        try {
            $this->paymentService->handleSuccessfulPayment($paymentIntentId);
            
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
                case 'payment_intent.succeeded':
                    $this->paymentService->handleSuccessfulPayment(
                        $event->data->object->id
                    );
                    break;

                case 'payment_intent.payment_failed':
                    $this->paymentService->handleFailedPayment(
                        $event->data->object->id
                    );
                    break;
            }

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
