<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Middleware\PreventAccessWhenAuthenticated;
use App\Http\Middleware\RedirectIfUnauthenticated;
use App\Http\Controllers\ActivityLogController;

Route::middleware('guest')->get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware([PreventAccessWhenAuthenticated::class])->group(function () {
    Route::get('/register', [RegistrationController::class, 'create'])->name('register');
    Route::post('/register', [RegistrationController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::middleware([RedirectIfUnauthenticated::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity.log');


