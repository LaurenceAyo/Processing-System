<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueTicketController;
use App\Http\Controllers\CounterController;

// --- Queue Tickets ---
Route::get('/tickets', [QueueTicketController::class , 'index']); // List all tickets (for display monitor)
Route::post('/tickets', [QueueTicketController::class , 'store']); // Generate a new ticket

// --- Counters ---
Route::get('/counters', [CounterController::class , 'index']); // List all counters + current ticket
Route::post('/counters/{counter}/next', [CounterController::class , 'next']); // Call next waiting ticket
Route::post('/counters/{counter}/skip', [CounterController::class , 'skip']); // Skip current ticket
Route::post('/counters/{counter}/recall', [CounterController::class , 'recall']); // Recall current ticket
