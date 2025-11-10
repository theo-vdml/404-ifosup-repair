<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\StaticPageController::class, 'index'])->name('homepage');
Route::get('/about', [App\Http\Controllers\StaticPageController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\StaticPageController::class, 'contact'])->name('contact');
Route::get('/terms', [App\Http\Controllers\StaticPageController::class, 'terms'])->name('terms');
Route::get('/staticform', [App\Http\Controllers\StaticPageController::class, 'staticform'])->name('staticform');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Dashboard routes import
require __DIR__ . '/dashboard.php';

// Api routes import
require __DIR__ . '/api.php';
