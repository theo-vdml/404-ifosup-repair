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
use App\Http\Controllers\TechnicianController;

Route::middleware('auth')->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('tickets', TicketController::class);
    Route::get('my-tickets', [TicketController::class, 'my'])->name('tickets.my');
    Route::resource('technicians', TechnicianController::class);

    Route::post('tickets/{ticket}/assign', [TicketController::class, 'assignUser'])->name('tickets.assign');
    Route::delete('tickets/{ticket}/unassign/{user}', [TicketController::class, 'unassignUser'])->name('tickets.unassign');
    Route::post('tickets/{ticket}/notes', [TicketController::class, 'storeNote'])->name('tickets.notes.store');
});
