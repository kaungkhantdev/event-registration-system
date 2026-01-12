@extends('layouts.app')

@section('title', 'Search Events')

@section('content')
<div class="sm:px-6 lg:px-8">

    <!-- Page Header -->
    <section class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                    <span class="block text-indigo-600">Search Events</span>
                </h1>
                <p class="mx-auto mt-4 max-w-2xl text-lg text-gray-600">
                    Find the perfect event for you with our advanced search filters
                </p>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- Horizontal Filters -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-filter text-indigo-600 mr-2"></i>
                    Filters
                </h2>
                <span class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    Found <span class="font-semibold text-indigo-600">{{ $events->total() }}</span> event(s)
                </span>
            </div>

            <form method="GET" action="{{ route('events.search') }}" id="filterForm">
                <!-- Primary Filters Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Search Keyword -->
                    <div>
                        <label for="search" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            <i class="fas fa-search text-indigo-500 mr-1"></i>
                            Search Events
                        </label>
                        <input type="text"
                            name="search"
                            id="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Title, description..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            <i class="fas fa-map-marker-alt text-indigo-500 mr-1"></i>
                            Location
                        </label>
                        <input type="text"
                            name="location"
                            id="location"
                            value="{{ $filters['location'] ?? '' }}"
                            placeholder="City, venue..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>

                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            <i class="fas fa-calendar text-indigo-500 mr-1"></i>
                            From Date
                        </label>
                        <input type="date"
                            name="date_from"
                            id="date_from"
                            value="{{ $filters['date_from'] ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            <i class="fas fa-calendar-check text-indigo-500 mr-1"></i>
                            To Date
                        </label>
                        <input type="date"
                            name="date_to"
                            id="date_to"
                            value="{{ $filters['date_to'] ?? '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                </div>

                <!-- Secondary Filters Row -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <!-- Price Type -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            <i class="fas fa-tag text-indigo-500 mr-1"></i>
                            Price Type
                        </label>
                        <div class="flex gap-3">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio"
                                    name="price_type"
                                    value=""
                                    {{ empty($filters['price_type']) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                <span class="ml-1.5 text-sm text-gray-700">All</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio"
                                    name="price_type"
                                    value="free"
                                    {{ ($filters['price_type'] ?? '') === 'free' ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                <span class="ml-1.5 text-sm text-gray-700">Free</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio"
                                    name="price_type"
                                    value="paid"
                                    {{ ($filters['price_type'] ?? '') === 'paid' ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                <span class="ml-1.5 text-sm text-gray-700">Paid</span>
                            </label>
                        </div>
                    </div>

                    <!-- Availability Checkbox -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            <i class="fas fa-check-circle text-indigo-500 mr-1"></i>
                            Availability
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                name="availability"
                                value="available"
                                {{ ($filters['availability'] ?? '') === 'available' ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="ml-2 text-sm text-gray-700">Available only</span>
                        </label>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label for="sort_by" class="block text-xs font-semibold text-gray-700 mb-1.5">
                            <i class="fas fa-sort text-indigo-500 mr-1"></i>
                            Sort By
                        </label>
                        <select name="sort_by"
                            id="sort_by"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="date" {{ ($filters['sort_by'] ?? 'date') === 'date' ? 'selected' : '' }}>Event Date</option>
                            <option value="title" {{ ($filters['sort_by'] ?? '') === 'title' ? 'selected' : '' }}>Title (A-Z)</option>
                            <option value="price_low" {{ ($filters['sort_by'] ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ ($filters['sort_by'] ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors font-medium text-sm shadow-md hover:shadow-lg">
                            <i class="fas fa-search mr-1"></i>
                            Search
                        </button>
                        <a href="{{ route('events.search') }}"
                            class="flex-shrink-0 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Events Grid Section -->
        <div>
            @if($events->isEmpty())
                <div class="text-center py-20 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-sm">
                    <div class="max-w-md mx-auto">
                        <div class="bg-white rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <i class="fas fa-search text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">No events found</h3>
                        <p class="text-gray-600 mb-6">Try adjusting your filters or search criteria to find more events</p>
                        <a href="{{ route('events.search') }}"
                            class="inline-flex items-center justify-center py-3 px-6 rounded-full bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                            <i class="fas fa-redo mr-2"></i>
                            Clear All Filters
                        </a>
                    </div>
                </div>
            @else
                <!-- Events Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class=" group relative bg-white rounded-3xl overflow-hidden shadow hover:shadow-2xl transition-all duration-500">
                            <!-- Image Section -->
                            <div class="relative h-56 overflow-hidden">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" 
                                        alt="{{ $event->title }}" 
                                        class="w-full h-full rounded-lg object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full rounded-lg bg-gradient-to-br from-violet-500 via-purple-500 to-fuchsia-500">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-white text-6xl opacity-30"></i>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Status Badge -->
                                @if($event->available_slots < 10)
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                            Last {{ $event->available_slots }} spots
                                        </span>
                                    </div>
                                @endif

                                <!-- Price Badge -->
                                <div class="absolute top-5 right-4">
                                    @if($event->isFree())
                                        <span class="bg-green-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                            FREE
                                        </span>
                                    @else
                                        <span class="bg-white text-gray-900 text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                            ${{ number_format($event->price, 2) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Overlay gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-6">
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 min-h-[3.5rem] group-hover:text-indigo-600 transition-colors duration-200">
                                    {{ $event->title }}
                                </h3>

                                <!-- Event Info -->
                                <div class="space-y-2.5 mb-4">
                                    <div class="flex items-start text-gray-600">
                                        <div class="flex-shrink-0 w-5 h-5 flex items-center justify-center mt-0.5">
                                            <i class="fas fa-calendar text-indigo-500 text-sm"></i>
                                        </div>
                                        <span class="ml-3 text-sm leading-tight">
                                            {{ $event->event_date->format('l, M d, Y') }}<br>
                                            <span class="text-indigo-600 font-semibold">{{ $event->event_date->format('g:i A') }}</span>
                                        </span>
                                    </div>

                                    <div class="flex items-center text-gray-600">
                                        <div class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                                            <i class="fas fa-map-marker-alt text-indigo-500 text-sm"></i>
                                        </div>
                                        <span class="ml-3 text-sm line-clamp-1">{{ $event->location }}</span>
                                    </div>

                                    <div class="flex items-center text-gray-600">
                                        <div class="flex-shrink-0 w-5 h-5 flex items-center justify-center">
                                            <i class="fas fa-users text-indigo-500 text-sm"></i>
                                        </div>
                                        <span class="ml-3 text-sm">
                                            <span class="font-semibold text-gray-900">{{ $event->available_slots }}</span> spots left
                                        </span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-5 line-clamp-2 min-h-[2.5rem] leading-relaxed">
                                    {{ Str::limit($event->description, 100) }}
                                </p>

                                <!-- CTA Button -->
                                <a href="{{ route('events.show', $event->id) }}" class="text-indigo-500">
                                    <span class="relative z-10 flex items-center justify-end">
                                        View More
                                        <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform duration-300"></i>
                                    </span>
                                    <div class="absolute inset-0 bg-white opacity-0 group-hover/btn:opacity-10 transition-opacity duration-300"></div>
                                </a>
                            </div>

                            <!-- Bottom accent line -->
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($events->hasPages())
                    <div class="mt-8 flex justify-center">
                        {{ $events->appends($filters)->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>

</div>
@endsection
