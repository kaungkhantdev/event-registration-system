<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display list of events
     */
    public function index()
    {
        $events = $this->eventService->getActiveEvents();
        return view('events.index', compact('events'));
    }

    /**
     * Display event details
     */
    public function show(int $id)
    {
        $event = $this->eventService->getEventById($id);
        $stats = $this->eventService->getEventStats($event);
        
        $userRegistered = false;
        if (auth()->check()) {
            $userRegistered = $event->registrations()
                ->where('user_id', auth()->id())
                ->exists();
        }

        return view('events.show', compact('event', 'stats', 'userRegistered'));
    }
}
