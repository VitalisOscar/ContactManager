<?php

use App\Http\Controllers\Auth\SignupController;
use Illuminate\Support\Facades\Route;

// User Authentication
Route::prefix('account')
->name('account')
->group(function () {

    // User Registration
    Route::get('register', [SignupController::class, 'showForm'])->name('.register');
    Route::post('register', [SignupController::class, 'signup']);

});
// End User Authentication

// User area
Route::prefix('app')
->name('app')
->middleware(['auth'])
->group(function () {

    // Dashboard
    Route::get('/', function () {
        return response('Logged in');
    })->name('.dashboard');

});
