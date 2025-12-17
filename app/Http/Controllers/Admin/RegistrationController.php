<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Services\RegistrationService;
use Illuminate\Http\Request;
use Exception;

class RegistrationController extends Controller
{
    public function __construct(
        private RegistrationService $registrationService
    ) { }

    /**
     * Display all registrations
     */
    public function index(Request $request)
    {
        $query = Registration::with(['user', 'event']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('event_id') && $request->event_id !== 'all') {
            $query->where('event_id', $request->event_id);
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Approve registration
     */
    public function approve(Registration $registration)
    {
        try {
            $this->registrationService->approveRegistration($registration);

            return back()->with('success', 'Registration approved successfully.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reject registration
     */
    public function reject(Registration $registration)
    {
        try {
            $this->registrationService->rejectRegistration($registration);

            return back()->with('success', 'Registration rejected successfully.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
