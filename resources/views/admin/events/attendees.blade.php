@extends('layouts.app')

@section('title', 'Event Attendees')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <a href="{{ route('admin.events.index') }}" class="text-indigo-600 hover:text-indigo-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Events
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xs p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $event->title }}</h1>
                <p class="text-gray-600">
                    <i class="fas fa-calendar-day mr-2"></i>{{ $event->event_date->format('F j, Y g:i A') }}
                </p>
            </div>

            <!-- Registration Status Tabs -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="filterRegistrations('all')" 
                                class="filter-tab border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            All ({{ $event->registrations->count() }})
                        </button>
                        <button onclick="filterRegistrations('approved')" 
                                class="filter-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Approved ({{ $event->registrations->where('status', 'approved')->count() }})
                        </button>
                        <button onclick="filterRegistrations('pending')" 
                                class="filter-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Pending ({{ $event->registrations->where('status', 'pending')->count() }})
                        </button>
                        <button onclick="filterRegistrations('rejected')" 
                                class="filter-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Rejected ({{ $event->registrations->where('status', 'rejected')->count() }})
                        </button>
                    </nav>
                </div>
            </div>

            @if($event->registrations->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-users text-6xl text-gray-400 mb-4"></i>
                    <p class="text-xl text-gray-600">No registrations yet for this event.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($event->registrations as $registration)
                                <tr class="registration-row hover:bg-gray-50" data-status="{{ $registration->status }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $registration->user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $registration->user->email }}</div>
                                        @if($registration->user->phone)
                                            <div class="text-sm text-gray-500">{{ $registration->user->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $registration->registered_at->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $registration->registered_at->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">${{ number_format($registration->amount_paid, 2) }}</div>
                                        @if($registration->payment_status)
                                            <div class="text-xs text-gray-500">{{ ucfirst($registration->payment_status) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($registration->status === 'approved') bg-green-100 text-green-800
                                            @elseif($registration->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($registration->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($registration->status === 'pending')
                                            <form method="POST" action="{{ route('admin.registrations.approve', $registration) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.registrations.reject', $registration) }}" 
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to reject this registration?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function filterRegistrations(status) {
    const rows = document.querySelectorAll('.registration-row');
    const tabs = document.querySelectorAll('.filter-tab');
    
    // Update tab styling
    tabs.forEach(tab => {
        tab.classList.remove('border-indigo-500', 'text-indigo-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    event.target.classList.remove('border-transparent', 'text-gray-500');
    event.target.classList.add('border-indigo-500', 'text-indigo-600');
    
    // Filter rows
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection
