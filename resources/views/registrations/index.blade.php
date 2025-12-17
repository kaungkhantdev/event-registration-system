@extends('layouts.app')

@section('title', 'My Registrations')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Registrations</h1>

    @if($registrations->isEmpty())
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-ticket-alt text-6xl text-gray-400 mb-4"></i>
            <p class="text-xl text-gray-600 mb-4">You haven't registered for any events yet.</p>
            <a href="{{ route('events.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg">
                Browse Events
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($registrations as $registration)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $registration->event->title }}</h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span>
                                        <i class="fas fa-calendar-day mr-1"></i>
                                        {{ $registration->event->event_date->format('M d, Y g:i A') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $registration->event->location }}
                                    </span>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($registration->status === 'approved') bg-green-100 text-green-800
                                @elseif($registration->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($registration->status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Registration Date</p>
                                <p class="text-lg font-medium text-gray-900">{{ $registration->registered_at->format('M d, Y') }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Amount Paid</p>
                                <p class="text-lg font-medium text-gray-900">${{ number_format($registration->amount_paid, 2) }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Payment Status</p>
                                <p class="text-lg font-medium text-gray-900">
                                    {{ $registration->payment_status ? ucfirst($registration->payment_status) : 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('events.show', $registration->event_id) }}" 
                               class="text-indigo-600 hover:text-indigo-700 font-medium">
                                View Event Details →
                            </a>
                            
                            @if($registration->status === 'pending' || $registration->status === 'approved')
                                <form method="POST" action="{{ route('registrations.destroy', $registration->id) }}" 
                                      onsubmit="return confirm('Are you sure you want to cancel this registration?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Cancel Registration
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
