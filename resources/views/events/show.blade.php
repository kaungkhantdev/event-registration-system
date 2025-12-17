@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($event->image)
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-96 object-cover">
        @else
            <div class="w-full h-96 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                <i class="fas fa-calendar-alt text-white text-9xl"></i>
            </div>
        @endif

        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($event->status === 'active') bg-green-100 text-green-800
                        @elseif($event->status === 'completed') bg-gray-100 text-gray-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-indigo-600">
                        @if($event->isFree())
                            FREE
                        @else
                            ${{ number_format($event->price, 2) }}
                        @endif
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-day text-indigo-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Event Date</p>
                            <p class="text-lg font-medium text-gray-900">{{ $event->event_date->format('F j, Y') }}</p>
                            <p class="text-sm text-gray-600">{{ $event->event_date->format('g:i A') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-indigo-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="text-lg font-medium text-gray-900">{{ $event->location }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-indigo-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Registration Deadline</p>
                            <p class="text-lg font-medium text-gray-900">{{ $event->registration_deadline->format('F j, Y') }}</p>
                            <p class="text-sm text-gray-600">{{ $event->registration_deadline->format('g:i A') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-indigo-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Available Slots</p>
                            <p class="text-lg font-medium text-gray-900">
                                {{ $stats['available_slots'] }} / {{ $event->max_attendees }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Event</h2>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
            </div>

            @auth
                @if($userRegistered)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <div>
                                <h3 class="text-lg font-medium text-green-900">You're Registered!</h3>
                                <p class="text-sm text-green-700">You have successfully registered for this event.</p>
                            </div>
                        </div>
                    </div>
                @else
                    @if($event->isRegistrationOpen())
                        <form method="POST" action="{{ route('registrations.store', $event) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                                <i class="fas fa-ticket-alt mr-2"></i>
                                Register Now
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                            <p class="text-gray-600 font-medium">Registration is closed for this event</p>
                        </div>
                    @endif
                @endif
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                    <p class="text-gray-600 mb-4">Please login to register for this event</p>
                    <a href="{{ route('login') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg">
                        Login to Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
