<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC HOMEPAGE (The Green Page)
|--------------------------------------------------------------------------
*/
// When you visit 'localhost', show the Courts List (Green Page)
Route::get('/', [CourtController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // --- TRAFFIC COP ---
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    })->name('dashboard');

    // --- STUDENT BOOKING ROUTES ---
    Route::get('/courts/{id}/book', [BookingController::class, 'create'])->name('bookings.create');
    
    // ... inside auth middleware group ...

    // AJAX Route to check availability
    Route::get('/bookings/check', [BookingController::class, 'checkAvailability'])->name('bookings.check');

    Route::get('/courts/{id}/book', [BookingController::class, 'create'])->name('bookings.create');
    // ... other routes

    // Save the Booking logic
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    
    // **NEW**: Show Confirmation Page (Green Checkmark Page)
    Route::get('/bookings/confirmation/{group_id}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');

    // My Dashboard (Booking History)
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.dashboard');


    // --- ADMIN BACKEND ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            $recent_bookings = \App\Models\Booking::with(['user', 'court'])->latest()->take(5)->get();
            return view('admin.dashboard', compact('recent_bookings'));
        })->name('dashboard');

        Route::resource('courts', CourtController::class)->except(['index', 'show']);
        
        Route::post('/bookings/approve/{group_id}', [BookingController::class, 'approve'])->name('bookings.approve');
        Route::post('/bookings/reject/{group_id}', [BookingController::class, 'reject'])->name('bookings.reject');
        // Admin Manage Bookings
    Route::get('/bookings', [BookingController::class, 'indexAdmin'])->name('bookings.index');
    // Edit Booking Routes
    Route::get('/bookings/{group_id}/edit', [BookingController::class, 'editAdmin'])->name('bookings.edit');
    Route::post('/bookings/{group_id}/update', [BookingController::class, 'updateAdmin'])->name('bookings.update');
    
    // REPLACE the old student route with this:
    Route::get('/users', [BookingController::class, 'userList'])->name('users.index');

});

    // Payment Page (Show the Form)
    Route::get('/payment/{group_id}', [BookingController::class, 'payment'])->name('bookings.payment');
    
    // Submit Payment (Handle Form & File) -> CHANGED TO POST
    Route::post('/payment/submit/{group_id}', [BookingController::class, 'submitPayment'])->name('bookings.submit_payment');
    
    Route::post('/bookings/cancel/{group_id}', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
});