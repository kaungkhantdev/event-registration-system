@extends('layouts.app')

@section('title', 'Privacy Policy - Event Hub')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Privacy Policy</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">Your privacy is important to us.</p>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
            <p class="text-gray-600 mb-8">Last updated: {{ date('F d, Y') }}</p>

            <div class="prose prose-lg max-w-none">
                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Introduction</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Welcome to Event Hub. We respect your privacy and are committed to protecting your personal data.
                        This privacy policy will inform you about how we look after your personal data when you visit our
                        website and tell you about your privacy rights and how the law protects you.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Information We Collect</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">We may collect, use, store and transfer different kinds of personal data about you:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li><strong>Identity Data:</strong> includes first name, last name, username or similar identifier.</li>
                        <li><strong>Contact Data:</strong> includes email address and telephone numbers.</li>
                        <li><strong>Transaction Data:</strong> includes details about payments and event registrations.</li>
                        <li><strong>Technical Data:</strong> includes internet protocol (IP) address, browser type and version, time zone setting and location.</li>
                        <li><strong>Usage Data:</strong> includes information about how you use our website and services.</li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">3. How We Use Your Information</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">We use your personal data for the following purposes:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>To register you for events and process your registrations</li>
                        <li>To process and deliver your payments</li>
                        <li>To manage our relationship with you</li>
                        <li>To send you relevant event notifications and updates</li>
                        <li>To improve our website and services</li>
                        <li>To administer and protect our business and website</li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Data Security</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We have put in place appropriate security measures to prevent your personal data from being
                        accidentally lost, used or accessed in an unauthorized way. We use industry-standard encryption
                        for all payment processing through our secure payment partner, Stripe. We limit access to your
                        personal data to employees and third parties who have a business need to know.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Data Retention</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We will only retain your personal data for as long as necessary to fulfill the purposes we
                        collected it for, including for the purposes of satisfying any legal, accounting, or reporting
                        requirements. For event registration data, we typically retain records for a period of 3 years
                        after the event date.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Your Legal Rights</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">Under certain circumstances, you have rights under data protection laws in relation to your personal data:</p>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4">
                        <li>Request access to your personal data</li>
                        <li>Request correction of your personal data</li>
                        <li>Request erasure of your personal data</li>
                        <li>Object to processing of your personal data</li>
                        <li>Request restriction of processing your personal data</li>
                        <li>Request transfer of your personal data</li>
                        <li>Right to withdraw consent</li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Cookies</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Our website uses cookies to distinguish you from other users. This helps us provide you with a
                        good experience when you browse our website and also allows us to improve our site. By continuing
                        to browse the site, you are agreeing to our use of cookies.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Third-Party Links</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Our website may include links to third-party websites, plug-ins and applications. Clicking on
                        those links may allow third parties to collect or share data about you. We do not control these
                        third-party websites and are not responsible for their privacy statements.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Changes to This Policy</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We may update this privacy policy from time to time. We will notify you of any changes by posting
                        the new privacy policy on this page and updating the "Last updated" date at the top of this policy.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Contact Us</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        If you have any questions about this privacy policy or our privacy practices, please contact us:
                    </p>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-600">Email: privacy@eventhub.com</p>
                        <p class="text-gray-600">Address: 123 Event Street, New York, NY 10001</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
