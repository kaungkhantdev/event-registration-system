<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# Event Registration System

A complete full-stack Laravel application for managing event registrations with integrated Stripe payment processing.

## Features

### User Features
- User registration and authentication
- Browse available events
- View detailed event information
- Register for events (free or paid)
- Secure payment processing via Stripe
- View registration history
- Cancel registrations
- Email notifications for registration confirmation

### Admin Features
- Admin dashboard with statistics
- Create, edit, and delete events
- Upload event images
- View all registrations
- Approve/reject registrations
- View event attendee lists
- Filter registrations by status and event
- Track revenue and attendance

## Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL
- **Payment**: Stripe Payment Integration
- **Architecture**: Service Layer Pattern, SOLID Principles

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & NPM (optional, for asset compilation)
- Stripe Account (for payment processing)

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd event-registration-system
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
cp .env.example .env
```

Edit `.env` file and configure:

```env
# Database
DB_DATABASE=event_registration
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

# Stripe (Get from https://dashboard.stripe.com/apikeys)
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
STRIPE_WEBHOOK_SECRET=your_webhook_secret

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@eventregistration.com
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Seed Database (Optional)

This creates sample admin and user accounts:

```bash
php artisan db:seed
```

**Default Credentials:**
- Admin: `admin@example.com` / `password`
- User: `user@example.com` / `password`

### 7. Create Storage Link

```bash
php artisan storage:link
```

### 8. Start the Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Stripe Configuration

### 1. Get Your Stripe Keys

1. Go to [Stripe Dashboard](https://dashboard.stripe.com)
2. Get your **Publishable Key** and **Secret Key** from the API section
3. Add them to your `.env` file

### 2. Setup Webhook

For local development, use Stripe CLI:

```bash
# Install Stripe CLI
# https://stripe.com/docs/stripe-cli

# Login to Stripe
stripe login

# Forward webhooks to your local server
stripe listen --forward-to localhost:8000/webhook/stripe
```

The CLI will give you a webhook signing secret. Add it to your `.env`:

```env
STRIPE_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxx
```

### 3. For Production

1. Go to Stripe Dashboard → Developers → Webhooks
2. Add endpoint: `https://yourdomain.com/webhook/stripe`
3. Select events: `payment_intent.succeeded`, `payment_intent.payment_failed`
4. Copy the webhook signing secret to your `.env`

## Usage

### For Users

1. **Register an Account**
   - Visit `/register` and create an account
   - Or use the test account: `user@example.com` / `password`

2. **Browse Events**
   - View all available events on the homepage
   - Click on any event to see details

3. **Register for an Event**
   - Click "Register Now" on the event page
   - For paid events, you'll be redirected to the payment page
   - Complete payment using Stripe (test cards available)

4. **View Registrations**
   - Go to "My Registrations" to see all your registered events
   - Cancel registrations if needed

### For Admins

1. **Login as Admin**
   - Use credentials: `admin@example.com` / `password`

2. **Create Events**
   - Go to Admin Dashboard → Create Event
   - Fill in event details, upload image, set price
   - Set registration deadline and max attendees

3. **Manage Events**
   - Edit or delete existing events
   - View event statistics
   - Check attendee lists

4. **Manage Registrations**
   - View all registrations across events
   - Approve/reject pending registrations
   - Filter by status or event

## Stripe Test Cards

Use these test cards in development:

- **Success**: `4242 4242 4242 4242`
- **Decline**: `4000 0000 0000 0002`
- **Auth Required**: `4000 0025 0000 3155`

Use any future expiry date, any 3-digit CVC, and any 5-digit ZIP.

## Email Configuration

### Local Development (Mailpit)

1. Install Mailpit: https://github.com/axllent/mailpit
2. Configure `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
```
3. View emails at: http://localhost:8025

### Production

Configure your SMTP settings in `.env` with your email provider credentials.

## Security Features

- ✅ CSRF Protection
- ✅ Password hashing with bcrypt
- ✅ SQL injection protection via Eloquent ORM
- ✅ XSS protection via Blade templating
- ✅ Role-based access control
- ✅ Secure payment processing via Stripe
- ✅ Webhook signature verification

## Testing Payment Flow

1. Create a paid event as admin
2. Register for the event as a user
3. Use test card `4242 4242 4242 4242`
4. Complete payment
5. Check that:
   - Registration status is "approved"
   - Payment record is created
   - User receives confirmation email
   - Event attendee count is updated

## Production Deployment

### 1. Environment Setup

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 2. Optimize Application

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Set File Permissions

```bash
chmod -R 755 storage bootstrap/cache
```

### 4. Configure Queue Workers

For better performance, use queue workers for email notifications:

```bash
php artisan queue:work
```

## API Documentation

### Webhook Endpoint

**POST** `/webhook/stripe`

Handles Stripe webhook events:
- `payment_intent.succeeded`: Updates payment and registration status
- `payment_intent.payment_failed`: Marks payment as failed

## Troubleshooting

### Payment Not Processing

1. Check Stripe keys in `.env`
2. Verify webhook secret is correct
3. Check Stripe logs in dashboard

### Emails Not Sending

1. Verify MAIL configuration in `.env`
2. Check mail driver is properly configured
3. For development, use Mailpit

### Images Not Displaying

1. Run `php artisan storage:link`
2. Check file permissions on `storage` directory

## Database Schema

### Users
- id, name, email, password, phone, role, timestamps

### Events
- id, title, description, location, event_date, registration_deadline, max_attendees, price, image, status, timestamps

### Registrations
- id, user_id, event_id, status, amount_paid, payment_id, payment_status, registered_at, timestamps

### Payments
- id, user_id, registration_id, stripe_payment_intent_id, amount, currency, status, metadata, timestamps

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues and questions, please create an issue in the repository.

## Credits

Developed following clean architecture principles and SOLID design patterns.
