<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;

use App\Http\Controllers\RegistrationController;

Route::get('/', function () {
    return view('landing');
});


// Registration routes
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store']);
// Contact routes
Route::get('contacts/create', [ContactController::class, 'create'])->name('contacts.create');
Route::post('contacts/store', [ContactController::class, 'store'])->name('contacts.store');
