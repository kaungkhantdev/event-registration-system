@extends('layouts.app')

@section('title', 'Terms of Service - Event Hub')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Terms of Service</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">Please read these terms carefully before using our service.</p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
            <p class="text-gray-600 mb-8">Last updated: {{ date('F d, Y') }}</p>

            <div class="prose prose-lg max-w-none">
                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Agreement to Terms</h2>
                    <p class="text-gray-600 leading-relaxed">
                        By accessing or using Event Hub, you agree to be bound by these Terms of Service and all
                        applicable laws and regulations. If you do not agree with any of these terms, you are
                        prohibited from using or accessing this site.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Use License</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Permission is granted to temporarily access the materials on Event Hub's website for personal,
                        non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Modify or copy the materials</li>
                        <li>Use the materials for any commercial purpose or public display</li>
                        <li>Attempt to decompile or reverse engineer any software on Event Hub</li>
                        <li>Remove any copyright or other proprietary notations</li>
                        <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">3. User Accounts</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">When you create an account with us, you must provide accurate and complete information. You are responsible for:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Maintaining the confidentiality of your account and password</li>
                        <li>Restricting access to your computer or device</li>
                        <li>All activities that occur under your account</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed mt-4">
                        You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Event Registration</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">By registering for an event through our platform:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>You agree to provide accurate registration information</li>
                        <li>You acknowledge that event details may be subject to change</li>
                        <li>You understand that registration may be subject to approval by event organizers</li>
                        <li>You agree to comply with any event-specific terms and conditions</li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Payments and Refunds</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">For paid events:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>All payments are processed securely through Stripe</li>
                        <li>Prices are displayed in the currency specified on the event page</li>
                        <li>Refund policies are set by individual event organizers</li>
                        <li>Event Hub is not responsible for refund decisions made by organizers</li>
                        <li>Processing fees may be non-refundable</li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Cancellations</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Event organizers reserve the right to cancel or postpone events. In such cases, registered
                        attendees will be notified via email. Refund policies for cancelled events are determined
                        by the event organizer. Event Hub is not liable for any costs incurred due to event
                        cancellation or changes.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Prohibited Activities</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">You agree not to:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Use the service for any illegal purpose</li>
                        <li>Harass, abuse, or harm other users</li>
                        <li>Submit false or misleading information</li>
                        <li>Interfere with or disrupt the service</li>
                        <li>Attempt to gain unauthorized access to any part of the service</li>
                        <li>Use automated systems to access the service without permission</li>
                        <li>Resell tickets or registrations without authorization</li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Intellectual Property</h2>
                    <p class="text-gray-600 leading-relaxed">
                        The service and its original content, features, and functionality are owned by Event Hub
                        and are protected by international copyright, trademark, patent, trade secret, and other
                        intellectual property laws.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Disclaimer</h2>
                    <p class="text-gray-600 leading-relaxed">
                        The materials on Event Hub are provided on an 'as is' basis. Event Hub makes no warranties,
                        expressed or implied, and hereby disclaims all warranties including, without limitation,
                        implied warranties of merchantability, fitness for a particular purpose, or non-infringement
                        of intellectual property.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Limitation of Liability</h2>
                    <p class="text-gray-600 leading-relaxed">
                        In no event shall Event Hub be liable for any damages (including, without limitation,
                        damages for loss of data or profit, or due to business interruption) arising out of the
                        use or inability to use the materials on Event Hub, even if Event Hub has been notified
                        of the possibility of such damage.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Termination</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We may terminate or suspend your account immediately, without prior notice or liability,
                        for any reason whatsoever, including without limitation if you breach the Terms. Upon
                        termination, your right to use the service will immediately cease.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">12. Changes to Terms</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We reserve the right to modify or replace these Terms at any time. If a revision is
                        material, we will try to provide at least 30 days' notice prior to any new terms taking
                        effect. What constitutes a material change will be determined at our sole discretion.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">13. Contact Us</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        If you have any questions about these Terms, please contact us:
                    </p>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-600">Email: legal@eventhub.com</p>
                        <p class="text-gray-600">Address: 123 Event Street, New York, NY 10001</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
