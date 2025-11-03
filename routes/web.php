<?php

use App\Http\Controllers\VesturesController;
use App\Http\Controllers\PieturasController;
use App\Http\Controllers\Mp3Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Mp3
Route::resource('mp3', Mp3Controller::class);

// Pieturas routes
Route::resource('pieturas', PieturasController::class);

// Vestures routes
Route::resource('vestures', VesturesController::class);

require __DIR__.'/auth.php';
