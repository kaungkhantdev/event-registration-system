<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1234567890',
        ]);

        // Create Regular User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '+1234567891',
        ]);

        // Create Sample Event
        \App\Models\Event::create([
            'title' => 'Tech Conference 2025',
            'description' => 'Join us for the biggest tech conference of the year! Network with industry leaders, attend workshops, and learn about the latest technologies.',
            'location' => 'San Francisco Convention Center',
            'event_date' => now()->addMonths(2),
            'registration_deadline' => now()->addMonth(),
            'max_attendees' => 500,
            'price' => 299.99,
            'status' => 'active',
        ]);

        \App\Models\Event::create([
            'title' => 'Free Community Meetup',
            'description' => 'A casual meetup for developers to connect and share ideas. Free pizza and drinks!',
            'location' => 'Tech Hub Downtown',
            'event_date' => now()->addWeeks(3),
            'registration_deadline' => now()->addWeeks(2),
            'max_attendees' => 50,
            'price' => 0,
            'status' => 'active',
        ]);
    }
}
