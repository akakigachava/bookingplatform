<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');

// Booking slots (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/book', [AppointmentController::class, 'book'])->name('book');
    Route::get('/book/slots', [AppointmentController::class, 'availableSlots'])->name('book.slots');
    Route::post('/book', [AppointmentController::class, 'store'])->name('book.store');

    Route::get('/my-bookings', [AppointmentController::class, 'myBookings'])->name('customer.bookings');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

// Dashboard redirect
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin + Staff routes
Route::middleware(['auth', 'staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/appointments', [Admin\AppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('/appointments/{appointment}/status', [Admin\AppointmentController::class, 'updateStatus'])->name('appointments.status');

    Route::get('/business-hours', [Admin\BusinessHourController::class, 'index'])->name('business-hours.index');
    Route::post('/business-hours', [Admin\BusinessHourController::class, 'update'])->name('business-hours.update');

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::resource('services', Admin\ServiceController::class)->except(['show']);
        // Staff CRUD — for teammate to implement
        // Route::resource('staff', Admin\StaffController::class)->except(['show']);
    });
});

require __DIR__.'/auth.php';
