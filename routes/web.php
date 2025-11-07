<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mp3Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VesturesController;
use App\Http\Controllers\PieturasController;

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
Route::get('/download/{id}', [Mp3Controller::class, 'download'])->name('mp3.download');
Route::post('/mp3/sync', [Mp3Controller::class, 'start'])->name('mp3.sync');

// Pieturas routes
Route::resource('pieturas', PieturasController::class);

// Vestures routes
Route::resource('vestures', VesturesController::class);

require __DIR__.'/auth.php';
