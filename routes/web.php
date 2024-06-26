<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Middleware\PreventAccessWhenAuthenticated;

// Landing page
Route::middleware('guest')->get('/', function () {
    return view('landing');
})->name('landing');

// Registration and Login routes for guests
Route::middleware([PreventAccessWhenAuthenticated::class])->group(function () {
    Route::get('/register', [RegistrationController::class, 'create'])->name('register');
    Route::post('/register', [RegistrationController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard contacts routes
    Route::prefix('dashboard/contacts')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('contacts.index');
        Route::get('/create', [DashboardController::class, 'createContact'])->name('contacts.create');
        Route::post('/store', [DashboardController::class, 'storeContact'])->name('contacts.store');
        Route::get('/edit/{contact}', [DashboardController::class, 'editContact'])->name('contacts.edit');
        Route::put('/update/{contact}', [DashboardController::class, 'updateContact'])->name('contacts.update');
        Route::delete('/destroy/{contact}', [DashboardController::class, 'destroyContact'])->name('contacts.destroy');

        // Contact Numbers Routes
        Route::get('/numbers/create', [DashboardController::class, 'createContactNumber'])->name('contact_numbers.create');
        Route::post('/numbers/store', [DashboardController::class, 'storeContactNumber'])->name('contact_numbers.store');
        Route::get('/numbers/edit/{contactNumber}', [DashboardController::class, 'editContactNumber'])->name('contact_numbers.edit');
        Route::put('/numbers/update/{contactNumber}', [DashboardController::class, 'updateContactNumber'])->name('contact_numbers.update');
        Route::delete('/numbers/destroy/{contactNumber}', [DashboardController::class, 'destroyContactNumber'])->name('contact_numbers.destroy');
    });

    // Logout route
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Prevent authenticated users from accessing login and register routes
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
});
