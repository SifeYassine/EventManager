<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Welcome/Home Page Route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route & Auth Middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Route & Auth Middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Events Routes & Auth Middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [EventController::class, 'index'])->name('dashboard');

    // All events route
    Route::get('/dashboard/all', [EventController::class, 'allEvents'])->name('dashboard.all');

    // Subscribed events route
    Route::get('/dashboard/subscribed', [EventController::class, 'subscribedEvents'])->name('dashboard.subscribed');

    // Event creation routes
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // Event update route
    Route::patch('/events/{event}', [EventController::class, 'update'])->name('events.update');

    // Event deletion route
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Subscription routes    
    Route::post('/events/{event}/subscribe', [SubscriptionController::class, 'subscribe'])->name('events.subscribe');
    Route::delete('/events/{event}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('events.unsubscribe');

    // Comment routes
    Route::post('/events/{event}/comments', [CommentController::class, 'store'])->name('comments.store');
});

require __DIR__.'/auth.php';
