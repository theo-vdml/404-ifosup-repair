<?php

use App\Http\Controllers\CustomerApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('api')->group(function () {

    Route::get('/customers', [CustomerApiController::class, 'index'])->name('api.customers.index');
});
