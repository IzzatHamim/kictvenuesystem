<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\Admin\AdminVenueController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Public Home Page
Route::get('/', [VenueController::class, 'index'])->name('home');

// Breeze Default Dashboard (for regular users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Venue Routes
Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');

// Booking Routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

// Admin Routes (protected by admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('venues', AdminVenueController::class);
});