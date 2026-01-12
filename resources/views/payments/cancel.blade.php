@extends('layouts.app')

@section('title', 'Payment Cancelled')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xs p-12 text-center">
            <div class="mb-6">
                <i class="fas fa-times-circle text-yellow-500 text-8xl"></i>
            </div>
            
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Payment Cancelled</h1>
            <p class="text-xl text-gray-600 mb-8">
                Your payment was not processed. You can try again or browse other events.
            </p>

            <div class="space-x-4">
                <a href="{{ route('events.index') }}" 
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg">
                    Browse Events
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
