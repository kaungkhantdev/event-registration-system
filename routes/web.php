<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes
Route::get('/', function () {
    return redirect()->route('events.index');
});

// Static Pages
Route::view('/about', 'pages.about')->name('pages.about');
Route::view('/contact', 'pages.contact')->name('pages.contact');
Route::view('/privacy', 'pages.privacy')->name('pages.privacy');
Route::view('/terms', 'pages.terms')->name('pages.terms');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public Event Routes
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/search/filter', [EventController::class, 'search'])->name('events.search');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// User Routes (Authenticated)
Route::middleware('auth')->group(function () {
    // User Registrations
    Route::get('/my-registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::delete('/registrations/{id}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');
    
    // Payment Routes
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::post('/payment/retry/{registrationId}', [PaymentController::class, 'retry'])->name('payment.retry');
});

// Stripe Webhook (no CSRF protection)
Route::post('/webhook/stripe', [PaymentController::class, 'webhook'])->name('webhook.stripe');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Event Management
    Route::resource('events', AdminEventController::class);
    Route::get('/events/{event}/attendees', [AdminEventController::class, 'attendees'])->name('events.attendees');
    
    // Registration Management
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::patch('/registrations/{registration}/approve', [AdminRegistrationController::class, 'approve'])->name('registrations.approve');
    Route::patch('/registrations/{registration}/reject', [AdminRegistrationController::class, 'reject'])->name('registrations.reject');
});
