# BookEase — Appointment Booking Platform

A full-featured appointment booking system for small service businesses (salons, barbershops, spas), built with Laravel 13 and a Material Design 3 admin interface.

---

## Features

### Customer Side
- Browse available services grouped by category
- Book appointments — pick a service, staff member, date, and available time slot
- View and manage personal bookings
- Cancel appointments (min. 2 hours before start)
- **Book Again** — one-click re-booking from past appointments

### Admin Panel
- **Dashboard** — live stats (today's bookings, upcoming, total customers, monthly revenue), today's schedule, upcoming appointments
- **Appointments** — full list with date/status filters, inline status update, mark appointments as done
- **Create Booking** — admin can book on behalf of existing customers or walk-in clients
- **Services** — add/edit/delete services with category, price, duration, and active status
- **Staff** — add/edit/remove staff members linked to user accounts
- **Customers** — view all registered and walk-in customers with booking history
- **Business Hours** — configure open/closed days and times per weekday
- **Staff Schedule** — staff members see only their own today's and upcoming appointments

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 13 (PHP 8.3) |
| Auth | Laravel Breeze (Blade stack) |
| Database | SQLite |
| Frontend | Blade templates, Tailwind CSS, Alpine.js, Vite |
| UI Design | Material Design 3 (Manrope font, Material Symbols Outlined icons) |
| ORM | Eloquent |

---

## Setup

```bash
git clone <repo-url>
cd bookingplatform

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate --seed

npm run build
php artisan serve
```

**Default login credentials (seeded):**

| Role | Email | Password |
|---|---|---|
| Admin | admin@bookease.com | password |
| Staff | sarah@bookease.com | password |
| Customer | customer@bookease.com | password |

---

## Project Structure

```
app/
  Http/Controllers/
    Admin/          ← Admin & staff controllers
    AppointmentController.php   ← Customer booking flow
  Models/           ← User, Appointment, Service, Staff, BusinessHour
resources/views/
  admin/            ← Admin panel pages
  appointments/     ← Customer booking & my-bookings
  layouts/          ← app.blade.php, admin.blade.php
database/
  migrations/       ← Schema migrations
  seeders/          ← DatabaseSeeder with demo data
```

---

## Team

| Name | Role |
|---|---|
| Akaki | Backend development, full feature implementation, admin panel |
| Mariam Khetsuriani | UI/UX design, HTML mockups for admin panel redesign |
| Giorgi Ugulava | Email confirmation system (Mailable, templates, Mailtrap) |

---

## Assignment

Web Development course project — submitted 26 June 2026.
