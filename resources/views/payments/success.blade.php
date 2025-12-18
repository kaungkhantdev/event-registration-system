@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white rounded-2xl shadow-xs p-12 text-center">
            <div class="mb-6">
                <i class="fas fa-check-circle text-green-500 text-8xl"></i>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Payment Successful!</h1>
            <p class="text-xl text-gray-600 mb-8">
                Your registration has been confirmed. You will receive a confirmation email shortly.
            </p>

            <div class="space-x-4">
                <a href="{{ route('registrations.index') }}" 
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full">
                    View My Registrations
                </a>
                <a href="{{ route('events.index') }}" 
                class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-full">
                    Browse More Events
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
