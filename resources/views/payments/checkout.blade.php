@extends('layouts.app')

@section('title', 'Complete Payment')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Complete Your Registration</h1>

        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
            <h2 class="text-xl font-bold text-gray-900 mb-4">{{ $event->title }}</h2>
            <div class="space-y-2 text-gray-700">
                <p><i class="fas fa-calendar-day w-5 inline-block"></i> {{ $event->event_date->format('F j, Y g:i A') }}</p>
                <p><i class="fas fa-map-marker-alt w-5 inline-block"></i> {{ $event->location }}</p>
                <p class="text-2xl font-bold text-indigo-600 mt-4">
                    Total: ${{ number_format($event->price, 2) }}
                </p>
            </div>
        </div>

        <form id="payment-form">
            <div id="payment-element" class="mb-6">
                <!-- Stripe Elements will be inserted here -->
            </div>
            
            <div id="error-message" class="text-red-600 mb-4 hidden"></div>

            <button id="submit-button" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                <span id="button-text">Pay ${{ number_format($event->price, 2) }}</span>
                <span id="spinner" class="hidden">
                    <i class="fas fa-spinner fa-spin"></i> Processing...
                </span>
            </button>
        </form>

        <p class="text-sm text-gray-500 text-center mt-4">
            <i class="fas fa-lock mr-1"></i>
            Your payment is secure and encrypted
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $publishableKey }}');
    const options = {
        clientSecret: '{{ $clientSecret }}',
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#4f46e5',
            }
        }
    };

    const elements = stripe.elements(options);
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');
    const errorMessage = document.getElementById('error-message');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Disable button
        submitButton.disabled = true;
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');

        const {error} = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: '{{ route("payment.success") }}',
            },
        });

        if (error) {
            // Show error
            errorMessage.textContent = error.message;
            errorMessage.classList.remove('hidden');
            
            // Re-enable button
            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
        }
    });
</script>
@endpush
