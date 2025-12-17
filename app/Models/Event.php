<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'event_date',
        'registration_deadline',
        'max_attendees',
        'price',
        'image',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * Get event registrations
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get approved registrations
     */
    public function approvedRegistrations()
    {
        return $this->hasMany(Registration::class)->where('status', 'approved');
    }

    /**
     * Get registered users
     */
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'registrations')
            ->withPivot('status', 'amount_paid', 'payment_id', 'payment_status', 'registered_at')
            ->withTimestamps();
    }

    /**
     * Check if event is full
     */
    public function isFull(): bool
    {
        return $this->approvedRegistrations()->count() >= $this->max_attendees;
    }

    /**
     * Check if registration is open
     */
    public function isRegistrationOpen(): bool
    {
        return $this->status === 'active' 
            && Carbon::now()->lte($this->registration_deadline)
            && !$this->isFull();
    }

    /**
     * Get available slots
     */
    public function getAvailableSlotsAttribute(): int
    {
        return max(0, $this->max_attendees - $this->approvedRegistrations()->count());
    }

    /**
     * Check if event is free
     */
    public function isFree(): bool
    {
        return $this->price == 0;
    }
}
