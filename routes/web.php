<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', 'dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // books routes
    Route::get('books/borrow/create', [BookController::class, 'borrow'])
        ->name('books.borrow.create');
    Route::put('books/borrow', [BookController::class, 'borrowConfirm'])
        ->name('books.borrow.confirm');
    Route::get('books/borrowed', [BookController::class, 'borrowed'])
        ->name('books.borrowed');

    Route::resource('books', BookController::class);

    Route::put('return/{book}/to-shelf', [BookController::class, 'returnToShelf'])
        ->name('returnToShelf');

    // users routes
    Route::resource('users', UserController::class)->middleware('admin');

    // profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


require __DIR__ . '/auth.php';
