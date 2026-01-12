<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class EventService
{
    /**
     * Get all active events
     */
    public function getActiveEvents()
    {
        return Event::where('status', 'active')
            ->where('registration_deadline', '>=', now())
            ->orderBy('event_date', 'asc')
            ->get();
    }

    /**
     * Get event by ID
     */
    public function getEventById(int $id): ?Event
    {
        return Event::with(['registrations.user', 'approvedRegistrations'])->findOrFail($id);
    }

    /**
     * Create new event
     */
    public function createEvent(array $data): Event
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        return Event::create($data);
    }

    /**
     * Update event
     */
    public function updateEvent(Event $event, array $data): Event
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image
            if ($event->image) {
                $this->deleteImage($event->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        } else {
            // Remove image from data if not provided to keep existing image
            unset($data['image']);
        }

        $event->update($data);
        return $event->fresh();
    }

    /**
     * Delete event
     */
    public function deleteEvent(Event $event): bool
    {
        if ($event->image) {
            $this->deleteImage($event->image);
        }

        return $event->delete();
    }

    /**
     * Upload event image
     */
    private function uploadImage(UploadedFile $image): string
    {
        $path = $image->store('events', 'public');
        return $path;
    }

    /**
     * Delete event image
     */
    private function deleteImage(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Search and filter events
     */
    public function searchEvents(array $filters = [])
    {
        $query = Event::where('status', 'active')
            ->where('registration_deadline', '>=', now());

        // Search by keyword (title, description, location)
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by location
        if (!empty($filters['location'])) {
            $query->where('location', 'like', "%{$filters['location']}%");
        }

        // Filter by price type
        if (!empty($filters['price_type'])) {
            if ($filters['price_type'] === 'free') {
                $query->where('price', 0);
            } elseif ($filters['price_type'] === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->where('event_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('event_date', '<=', $filters['date_to']);
        }

        // Filter by availability
        if (!empty($filters['availability'])) {
            if ($filters['availability'] === 'available') {
                $query->whereRaw('(SELECT COUNT(*) FROM registrations WHERE event_id = events.id AND status = "approved") < max_attendees');
            }
        }

        // Sort
        $sortBy = $filters['sort_by'] ?? 'date';
        switch ($sortBy) {
            case 'date':
                $query->orderBy('event_date', 'asc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy('event_date', 'asc');
        }

        return $query->paginate(9);
    }

    /**
     * Get event statistics
     */
    public function getEventStats(Event $event): array
    {
        return [
            'total_registrations' => $event->registrations()->count(),
            'approved_registrations' => $event->approvedRegistrations()->count(),
            'pending_registrations' => $event->registrations()->where('status', 'pending')->count(),
            'rejected_registrations' => $event->registrations()->where('status', 'rejected')->count(),
            'available_slots' => $event->available_slots,
            'total_revenue' => $event->registrations()
                ->where('status', 'approved')
                ->sum('amount_paid'),
        ];
    }
}
