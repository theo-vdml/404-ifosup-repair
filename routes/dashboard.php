<?php

/**
 * --------------------------------------------------------------------------
 * Dashboard Routes
 * --------------------------------------------------------------------------
 * Routes liées au tableau de bord de l’application.
 * Accessibles uniquement aux utilisateurs authentifiés.
 *
 */

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('customers', CustomerController::class);
});
