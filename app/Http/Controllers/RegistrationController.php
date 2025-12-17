<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\RegistrationService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Exception;

class RegistrationController extends Controller
{
    public function __construct(
        private RegistrationService $registrationService,
        private PaymentService $paymentService
    ) {
        $this->middleware('auth');
    }

    /**
     * Display user's registrations
     */
    public function index()
    {
        $registrations = $this->registrationService->getUserRegistrations(auth()->user());
        return view('registrations.index', compact('registrations'));
    }

    /**
     * Register for an event
     */
    public function store(Request $request, Event $event)
    {
        try {
            $registration = $this->registrationService->registerForEvent(
                auth()->user(),
                $event
            );

            // If event requires payment
            if (!$event->isFree()) {
                $paymentData = $this->paymentService->createPaymentIntent($registration);
                
                return view('payments.checkout', [
                    'registration' => $registration,
                    'event' => $event,
                    'clientSecret' => $paymentData['client_secret'],
                    'publishableKey' => config('services.stripe.key'),
                ]);
            }

            return redirect()->route('registrations.index')
                ->with('success', 'Registration successful!');
                
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Cancel registration
     */
    public function destroy(int $id)
    {
        try {
            $registration = auth()->user()->registrations()->findOrFail($id);
            
            $this->registrationService->cancelRegistration($registration);

            return redirect()->route('registrations.index')
                ->with('success', 'Registration cancelled successfully.');
                
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
