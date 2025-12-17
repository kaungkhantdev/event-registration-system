<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Exception;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) { }

    /**
     * Display all events
     */
    public function index()
    {
        $events = Event::withCount(['registrations', 'approvedRegistrations'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show create event form
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store new event
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date', 'after:now'],
            'registration_deadline' => ['required', 'date', 'before:event_date'],
            'max_attendees' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'status' => ['required', 'in:active,inactive,completed'],
        ]);

        // Add the image file to validated data if present
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image');
        }

        try {
            $this->eventService->createEvent($validated);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event created successfully.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Show edit event form
     */
    public function edit(Event $event)
    {
        $stats = $this->eventService->getEventStats($event);
        return view('admin.events.edit', compact('event', 'stats'));
    }

    /**
     * Update event
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'registration_deadline' => ['required', 'date', 'before:event_date'],
            'max_attendees' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'status' => ['required', 'in:active,inactive,completed'],
        ]);

        // Add the image file to validated data if present
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image');
        }

        try {
            $this->eventService->updateEvent($event, $validated);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Delete event
     */
    public function destroy(Event $event)
    {
        try {
            $this->eventService->deleteEvent($event);

            return redirect()->route('admin.events.index')
                ->with('success', 'Event deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * View event attendees
     */
    public function attendees(Event $event)
    {
        $event->load(['registrations.user']);
        return view('admin.events.attendees', compact('event'));
    }
}
