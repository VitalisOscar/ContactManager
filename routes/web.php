<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Contacts\ContactsController;
use Illuminate\Support\Facades\Route;

// Start route should redirect to contact list
Route::get('', function(){
    return redirect()->route('app.contacts.all');
});

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

    Route::get('logout', [LoginController::class, 'logout'])->name('.logout');

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

        Route::get('create', [ContactsController::class, 'showForm'])->name('.create');
        Route::post('create', [ContactsController::class, 'create']);

        // Single contact
        Route::get('{contact}', [ContactsController::class, 'getSingle'])->name('.single');
        Route::patch('{contact}', [ContactsController::class, 'edit'])->name('.update');
        Route::delete('{contact}', [ContactsController::class, 'delete'])->name('.delete');

    });
    // End Contact management

});
// End User area
