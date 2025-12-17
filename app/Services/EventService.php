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
