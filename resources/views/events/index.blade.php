@extends('layouts.app')

@section('title', 'Available Events')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Upcoming Events</h1>
        <p class="text-lg text-gray-600">Discover and register for exciting events</p>
    </div>

    @if($events->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
            <p class="text-xl text-gray-600">No events available at the moment.</p>
            <p class="text-gray-500">Check back soon for new events!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-6xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h3>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar-day w-5"></i>
                                <span class="ml-2 text-sm">{{ $event->event_date->format('M d, Y g:i A') }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt w-5"></i>
                                <span class="ml-2 text-sm">{{ $event->location }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-users w-5"></i>
                                <span class="ml-2 text-sm">{{ $event->available_slots }} slots available</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-dollar-sign w-5"></i>
                                <span class="ml-2 text-sm font-bold">
                                    @if($event->isFree())
                                        FREE
                                    @else
                                        ${{ number_format($event->price, 2) }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ Str::limit($event->description, 120) }}
                        </p>

                        <a href="{{ route('events.show', $event->id) }}" 
                           class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
                            View Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
