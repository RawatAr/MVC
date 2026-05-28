<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BloodBankController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DonorController;

// Landing / Home page route (Unit II)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Blood Banks listing and detail routes
Route::get('/blood-banks', [BloodBankController::class, 'index'])->name('blood-banks.index');
Route::get('/blood-banks/{id}', [BloodBankController::class, 'show'])
    ->name('blood-banks.show')
    ->whereNumber('id'); // Parameter constraints (Unit III)

// JSON Response API endpoint (Unit VI / II)
Route::get('/api/blood-banks/{id}/stock', [BloodBankController::class, 'stockApi'])
    ->name('blood-banks.stock-api')
    ->whereNumber('id');

// Blood Requisitions routes
Route::get('/request/create', [BloodRequestController::class, 'create'])->name('request.create');
Route::post('/request', [BloodRequestController::class, 'store'])->name('request.store');
Route::get('/request/{id}/track', [BloodRequestController::class, 'track'])
    ->name('request.track')
    ->whereNumber('id');
Route::post('/request/{id}/status', [BloodRequestController::class, 'updateStatus'])
    ->name('request.update-status')
    ->whereNumber('id');

// Donation Camps / Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// Donor Routes (Unit IV Session management / Unit V Form Validation)
Route::prefix('donor')->group(function () {
    // Unauthenticated routes
    Route::get('/register', [DonorController::class, 'create'])->name('donor.register');
    Route::post('/register', [DonorController::class, 'store'])->name('donor.register.store');
    Route::get('/login', [DonorController::class, 'loginForm'])->name('donor.login');
    Route::post('/login', [DonorController::class, 'login'])->name('donor.login.submit');
    Route::get('/logout', [DonorController::class, 'logout'])->name('donor.logout');

    // Session-protected routes using custom AuthSessionMiddleware
    Route::middleware('auth.session')->group(function () {
        Route::get('/dashboard', [DonorController::class, 'dashboard'])->name('donor.dashboard');
        Route::post('/availability', [DonorController::class, 'toggleAvailability'])->name('donor.availability.toggle');
    });
});
