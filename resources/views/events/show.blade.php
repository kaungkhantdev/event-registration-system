@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <a href="{{ route('events.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-indigo-600 mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Events
        </a>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Event Image, Title, and Description -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Event Image Card -->
                <div class="bg-white rounded-2xl overflow-hidden">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-6xl opacity-50"></i>
                        </div>
                    @endif
                </div>

                <!-- Title and Description Card -->
                <div class="bg-white rounded-2xl p-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-start justify-between mb-3">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }}</h1>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ml-4
                                @if($event->status === 'active') bg-green-100 text-green-700
                                @elseif($event->status === 'completed') bg-gray-100 text-gray-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                        <p class="text-2xl font-bold text-indigo-600">
                            @if($event->isFree())
                                FREE
                            @else
                                ${{ number_format($event->price, 2) }}
                            @endif
                        </p>
                    </div>

                    <!-- Description -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-3">About This Event</h2>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Event Info and Registration -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Event Info Card -->
                <div class="bg-white rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Event Details</h3>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-calendar-day text-indigo-600 text-lg mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-500">Event Date</p>
                                <p class="font-semibold text-gray-900">{{ $event->event_date->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $event->event_date->format('g:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-indigo-600 text-lg mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p class="font-semibold text-gray-900">{{ $event->location }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <i class="fas fa-clock text-indigo-600 text-lg mt-1"></i>
                            <div>
                                <p class="text-sm text-gray-500">Registration Deadline</p>
                                <p class="font-semibold text-gray-900">{{ $event->registration_deadline->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $event->registration_deadline->format('g:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <i class="fas fa-users text-indigo-600 text-lg mt-1"></i>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500">Available Slots</p>
                                <p class="font-semibold text-gray-900">{{ $stats['available_slots'] }} / {{ $event->max_attendees }}</p>
                                <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($event->max_attendees - $stats['available_slots']) / $event->max_attendees * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Section Card -->
                <div class="bg-white rounded-2xl p-6">
                    @auth
                        @if($userRegistered)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-semibold text-green-900">You're Registered!</p>
                                        <p class="text-sm text-green-700">You have successfully registered for this event.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            @if($event->isRegistrationOpen())
                                <form method="POST" action="{{ route('registrations.store', $event) }}">
                                    @csrf
                                    <button type="submit" class="cursor-pointer w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-full transition-colors flex items-center justify-center">
                                        <i class="fas fa-ticket-alt mr-2"></i>
                                        Register for This Event
                                    </button>
                                </form>
                            @else
                                <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 text-center">
                                    <i class="fas fa-lock text-gray-400 text-2xl mb-2"></i>
                                    <p class="font-semibold text-gray-700">Registration is Closed</p>
                                </div>
                            @endif
                        @endif
                    @else
                        <div class="border border-gray-300 rounded-lg p-6 text-center">
                            <i class="fas fa-user-lock text-gray-400 text-3xl mb-3"></i>
                            <p class="font-semibold text-gray-900 mb-1">Login Required</p>
                            <p class="text-sm text-gray-600 mb-4">Please login to register for this event</p>
                            <a href="{{ route('login') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-full transition-colors">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Login to Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
