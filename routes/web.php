<?php

use App\Http\Controllers\CheckInController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- QR Code Pages (for office staff to print) ---
Route::get('/qr', [CheckInController::class , 'index']); // List all service QR codes
Route::get('/qr/{serviceType}', [CheckInController::class , 'showQr']); // Show/print one QR code

// --- Check-In (clients scan QR → lands here → gets a ticket) ---
// NOTE: the static /ticket/ route MUST come before the {serviceType} wildcard
Route::get('/checkin/ticket/{ticket}', [CheckInController::class , 'showTicket'])->name('checkin.ticket'); // Result page (safe to reload)
Route::get('/checkin/{serviceType}', [CheckInController::class , 'showCheckIn']); // Step 1: Confirmation
Route::post('/checkin/{serviceType}', [CheckInController::class , 'createTicket']); // Step 2: Create ticket → redirect


// --- Display Monitor (fullscreen, for the waiting area TV/screen) ---
Route::get('/display', fn() => view('display.monitor'));

// --- Staff Portal ---
Route::get('/staff', [App\Http\Controllers\StaffController::class , 'index']);
Route::get('/staff/{counter}', [App\Http\Controllers\StaffController::class , 'panel']);
