# BookEase — Project Description

**Course:** Web Development  
**Submission Date:** 26 June 2026  
**Team:** Akaki · Mariam Khetsuriani · Giorgi Ugulava  
**Repository:** [GitHub — see commit history]

---

## 1. Project Overview

BookEase is a web-based appointment booking platform designed for small service businesses such as salons, barbershops, and spas. The goal was to build a working, production-ready application that solves a real problem: small business owners typically rely on phone calls or paper diaries to manage bookings, leading to scheduling conflicts, missed cancellations, and no visibility into revenue.

BookEase replaces that with a two-sided platform — a simple booking flow for customers, and a full management panel for staff and admins.

---

## 2. Core Functionality

**For Customers:**
- Register, log in, and browse available services organized by category (Hair, Beard, Nails, Spa, etc.)
- Choose a service, a staff member, a date, and then see only genuinely available time slots (slots are computed based on existing bookings and business hours)
- Cancel bookings up to 2 hours before the appointment
- Re-book a past appointment in one click ("Book Again"), which pre-fills the form with the same service and staff

**For Staff:**
- Log in and see a personal schedule page showing today's appointments and the next 7 days
- Mark appointments as completed

**For Admins:**
- Full dashboard with live statistics: today's appointment count, upcoming bookings, total customers, and monthly revenue
- Create bookings on behalf of customers, including support for walk-in clients who have no account
- Manage services (add/edit/delete with category, price, duration)
- Manage staff members (create accounts, set active/inactive)
- View the full customer list with booking history, distinguishing registered users from walk-ins
- Configure business hours per weekday with open/close times
- Filter and update appointment statuses inline from the appointments table

---

## 3. Technical Implementation

The application was built with **Laravel 13** using the **Breeze** starter kit for authentication (Blade stack). The database is **SQLite** for simplicity. The frontend uses **Blade** templates, **Tailwind CSS**, **Alpine.js** for interactivity, and **Vite** for asset compilation.

Key technical decisions:

- **Role-based access control** is implemented via a `role` column on the `users` table (`customer`, `staff`, `admin`) with custom middleware (`AdminMiddleware`, `StaffMiddleware`).
- **Available slots** are computed server-side: the API subtracts booked time ranges from the business hours window for the selected day, respecting each service's duration.
- **Service categories** are stored as a nullable string column on the services table (no separate table), grouped at the query layer using Eloquent's `groupBy()`.
- **Walk-in customers** are created on the fly with a placeholder `@bookease.local` email so every booking has a user record, keeping the data model consistent.
- **Cancellation enforcement** is applied both in the UI (button hidden within 2 hours) and server-side (controller check) to prevent bypass.
- The **admin panel UI** follows the **Material Design 3** design system: custom color tokens (`#864461` primary, `#eddfe4` secondary-fixed, etc.), Manrope font, Material Symbols Outlined icon font, and an MD3 navigation rail sidebar with active state indicator.

---

## 4. Workflow

The project was built iteratively over several weeks, with features added one at a time and committed to a shared GitHub repository.

Development followed this order:
1. Core authentication and role system
2. Service and staff models with admin CRUD
3. Customer booking form with slot availability API
4. Appointment management for admins (list, status update)
5. Business hours configuration
6. Customer-facing bookings page with cancel
7. Book Again button with form pre-fill
8. Admin creates booking (existing customer + walk-in)
9. Cancellation minimum notice (2-hour rule)
10. Service categories
11. Staff schedule view
12. Customer list with walk-in detection
13. Full admin panel redesign (Material Design 3)
14. Login and registration page redesign (split-screen layout)
15. Email confirmation system

Each feature was committed separately so the git history reflects the progression clearly.

---

## 5. Division of Work

| Akaki | Mariam Khetsuriani | Giorgi Ugulava |
|---|---|---|
| Laravel project setup and configuration | Admin panel UI/UX design and mockups | Email confirmation system |
| Database schema and all migrations | HTML mockups for Dashboard, Appointments, Business Hours, and Services pages | Appointment confirmation Mailable and email templates |
| All backend controllers and business logic | Material Design 3 color system and component design | Mailtrap integration and testing |
| Blade views for customer and admin flows | Login and registration page design (split-screen layout) | Customer model — `appointments_count`, `last_appointment` relationships |
| Role-based middleware and routing | | Business hours model and database seeding |
| Slot availability algorithm | | |
| Walk-in customer creation | | |
| Cancellation enforcement | | |
| Staff schedule view | | |
| Integration of MD3 design and login/register redesign into Laravel | | |
| Bug fixes (migration conflicts, .env issues) | | |

---

## 6. What We Would Add With More Time

- **Extended email notifications** — reminders and cancellation emails in addition to booking confirmations
- **Customer profile page** — let customers edit their name, email, and password
- **Reporting** — export appointment data as CSV or generate a monthly revenue chart
- **SMS reminders** — send a reminder 24 hours before an appointment

---

*GitHub repository includes full commit history showing feature-by-feature development.*
