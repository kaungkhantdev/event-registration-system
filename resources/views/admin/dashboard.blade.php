@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-calendar-alt text-indigo-600 text-3xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Events</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_events'] }}</p>
                    <p class="text-sm text-green-600">{{ $stats['active_events'] }} active</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-purple-600 text-3xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-ticket-alt text-green-600 text-3xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Registrations</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_registrations'] }}</p>
                    <p class="text-sm text-yellow-600">{{ $stats['pending_registrations'] }} pending</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-dollar-sign text-yellow-600 text-3xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.events.create') }}" 
               class="flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i> Create Event
            </a>
            <a href="{{ route('admin.events.index') }}" 
               class="flex items-center justify-center bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-list mr-2"></i> Manage Events
            </a>
            <a href="{{ route('admin.registrations.index') }}" 
               class="flex items-center justify-center bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-users mr-2"></i> View Registrations
            </a>
            <a href="{{ route('admin.registrations.index', ['status' => 'pending']) }}" 
               class="flex items-center justify-center bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                <i class="fas fa-clock mr-2"></i> Pending Approvals
            </a>
        </div>
    </div>

    <!-- Recent Events -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Recent Events</h2>
            </div>
            <div class="p-6">
                @if($recentEvents->isEmpty())
                    <p class="text-gray-500 text-center py-4">No events yet</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentEvents as $event)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $event->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $event->event_date->format('M d, Y') }}</p>
                                </div>
                                <a href="{{ route('admin.events.edit', $event) }}" 
                                   class="text-indigo-600 hover:text-indigo-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Registrations -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Recent Registrations</h2>
            </div>
            <div class="p-6">
                @if($recentRegistrations->isEmpty())
                    <p class="text-gray-500 text-center py-4">No registrations yet</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentRegistrations as $registration)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $registration->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $registration->event->title }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($registration->status === 'approved') bg-green-100 text-green-800
                                    @elseif($registration->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
