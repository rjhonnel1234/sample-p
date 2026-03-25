<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        // If logged in, redirect to dashboard/home
        return redirect('/dashboard');
    }
    // If not logged in, show login view
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/send', [MessageController::class, 'sendForm']);
    Route::post('/send', [MessageController::class, 'send']);

    Route::get('/sent', [MessageController::class, 'sentMessages']);
    Route::get('/inbox', [MessageController::class, 'inbox']);
});

require __DIR__.'/auth.php';


