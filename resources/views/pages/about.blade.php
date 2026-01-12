@extends('layouts.app')

@section('title', 'About Us - Event Hub')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">About Event Hub</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">Your trusted platform for discovering and managing events seamlessly.</p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Mission Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
            <p class="text-lg text-gray-600 leading-relaxed">
                At Event Hub, we believe that great events bring people together. Our mission is to make event discovery
                and registration simple, secure, and enjoyable for everyone. Whether you're organizing a small workshop
                or attending a large conference, we're here to help you every step of the way.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">What We Offer</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Easy Discovery</h3>
                    <p class="text-gray-600">Find events that match your interests with our powerful search and filtering tools.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Simple Registration</h3>
                    <p class="text-gray-600">Register for events in just a few clicks with our streamlined process.</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Secure Payments</h3>
                    <p class="text-gray-600">Pay with confidence using our secure payment processing powered by Stripe.</p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
            <p class="text-lg text-gray-600 leading-relaxed mb-4">
                Event Hub was founded with a simple idea: make events accessible to everyone. We started as a small
                team passionate about bringing communities together through shared experiences.
            </p>
            <p class="text-lg text-gray-600 leading-relaxed">
                Today, we continue to grow and improve our platform, always keeping our users at the heart of
                everything we do. We're committed to providing the best event management experience possible.
            </p>
        </div>

        <!-- CTA Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Ready to Get Started?</h2>
            <p class="text-gray-600 mb-6">Browse our upcoming events and find something that inspires you.</p>
            <a href="{{ route('events.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-medium transition-colors">
                Explore Events
            </a>
        </div>
    </div>
</div>
@endsection
