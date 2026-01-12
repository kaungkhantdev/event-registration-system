@extends('layouts.app')

@section('title', 'Available Events')

@section('content')
<div class="sm:px-6 lg:px-8">

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-20 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                    Discover & Register for
                    <span class="block text-indigo-600">Amazing Events</span>
                </h1>
                <p class="mx-auto mt-6 max-w-2xl text-lg text-gray-600">
                    Find exciting events near you, register securely online, and never miss out on experiences that matter. Simple, fast, and reliable event registration.
                </p>
                <div class="mt-10 flex items-center justify-center gap-4 flex-wrap">
                    <a href="{{ route('events.search') }}" class="inline-flex items-center justify-center py-3 px-6 rounded-full border border-transparent text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Browse Events
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center py-3 px-6 rounded-full border border-indigo-600 text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create Account
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4">

        <!-- Features Section -->
        <section class="py-16">
            <div class="mx-auto max-w-7xl">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">Why Choose EventHub?</h2>
                    <p class="mt-4 text-gray-600">Everything you need for seamless event registration</p>
                </div>

                <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                            <i class="fas fa-bolt text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="mt-4 font-semibold text-gray-900">Fast Registration</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Register for events in seconds with our streamlined process
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                            <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="mt-4 font-semibold text-gray-900">Secure Payments</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Your payment information is protected with industry-standard encryption
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                            <i class="fas fa-calendar-check text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="mt-4 font-semibold text-gray-900">Event Management</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Easily track and manage all your registered events in one place
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                            <i class="fas fa-users text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="mt-4 font-semibold text-gray-900">Community</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Connect with like-minded people at events you love
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Events List -->
        <section id="events" class="py-16">
            <div class="mx-auto max-w-7xl">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Upcoming Events</h2>
                    <p class="mt-4 text-gray-600">Browse and register for exciting events</p>
                </div>

                @if($events->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
                        <p class="text-xl text-gray-600 mb-2">No events available at the moment.</p>
                        <p class="text-gray-500">Check back soon for new events!</p>
                    </div>
                @else
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
                @endif
            </div>
        </section>

        <!-- CTA Section -->
        @guest
        <section class="py-16">
            <div class="mx-auto max-w-7xl">
                <div class="rounded-2xl bg-indigo-600 px-8 py-16 text-center text-white shadow-xl">
                    <h2 class="text-3xl font-bold">Ready to Get Started?</h2>
                    <p class="mx-auto mt-4 max-w-xl text-indigo-100">
                        Create your account today and start discovering amazing events in your area.
                    </p>
                    <a href="{{ route('register') }}" class="mt-8 inline-flex items-center justify-center py-3 px-6 rounded-full border-2 border-white text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors">
                        Sign Up Free
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </section>
        @endguest
    </div>


</div>
@endsection
