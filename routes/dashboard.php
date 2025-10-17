<?php

/**
 * --------------------------------------------------------------------------
 * Dashboard Routes
 * --------------------------------------------------------------------------
 * Routes liées au tableau de bord de l’application.
 * Accessibles uniquement aux utilisateurs authentifiés.
 *
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TicketController;

Route::middleware('auth')->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('tickets', TicketController::class);
});
