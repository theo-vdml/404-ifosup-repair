<?php

use App\Http\Controllers\CustomerApiController;
use App\Http\Controllers\UserApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('api')->group(function () {

    Route::get('/customers', [CustomerApiController::class, 'index'])->name('api.customers.index');
    Route::get('/users', [UserApiController::class, 'index'])->name('api.users.index');
});
