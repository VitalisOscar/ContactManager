<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Contacts\ContactsController;
use Illuminate\Support\Facades\Route;

// User Authentication
Route::prefix('account')
->name('account')
->group(function () {

    // User Registration
    Route::get('register', [SignupController::class, 'showForm'])->name('.register');
    Route::post('register', [SignupController::class, 'signup']);

    // Login
    Route::get('login', [LoginController::class, 'showForm'])->name('.login');
    Route::post('login', [LoginController::class, 'login']);

});
// End User Authentication


// User area
Route::prefix('app')
->name('app')
->middleware(['auth'])
->group(function () {

    // Dashboard
    Route::get('/', function () {
        return redirect()->route('app.contacts.all');
    })->name('.dashboard');

    // Contact management
    Route::prefix('contacts')
    ->name('.contacts')
    ->group(function () {

        Route::get('/', [ContactsController::class, 'getAll'])->name('.all');

        Route::get('create', [])->name('.create');
        Route::post('create', [ContactsController::class, 'create']);

        // Single contact
        Route::get('{contact}', [])->name('.single');

        Route::patch('{contact}', [])->name('.update');
        Route::delete('{contact}', [])->name('.delete');

    });
    // End Contact management

});
// End User area
