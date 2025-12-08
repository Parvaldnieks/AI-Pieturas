<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mp3Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValodasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VesturesController;
use App\Http\Controllers\PieturasController;
use App\Http\Controllers\TulkojumsController;
use App\Http\Controllers\ApiAccessController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/sync/progress/{id}', function ($id) {$batch = Bus::findBatch($id);
    if (! $batch) {
        return ['error' => 'Batch not found'];
    }

    if ($batch->finished()) {
        session()->forget('last_batch');
    }

    return [
        'total'     => $batch->totalJobs,
        'processed' => $batch->processedJobs(),
        'failed'    => $batch->failedJobs,
        'pending'   => $batch->pendingJobs,
        'progress'  => $batch->progress(),
        'finished'  => $batch->finished(),
    ];
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Mp3
Route::resource('mp3', Mp3Controller::class)->middleware('permission:skatit_pieturas');
Route::get('/download/{id}', [Mp3Controller::class, 'download'])->name('mp3.download');
Route::post('/mp3/sync', [Mp3Controller::class, 'start'])->name('mp3.sync');

// Pieturas routes
Route::resource('pieturas', PieturasController::class)
    ->middleware('permission:skatit_pieturas');

// Vestures routes
Route::resource('vestures', VesturesController::class)
    ->middleware('permission:skatit_pieturas');

// Adminstrators
Route::middleware('admin')->group(function () {
    Route::resource('users', UserController::class);
});

// Valodas
Route::post('/valodas/{valoda}/sync', [ValodasController::class, 'start'])->name('valodas.sync');
Route::resource('valodas', ValodasController::class);
Route::post('/valodas/maina', [ValodasController::class, 'switch'])->name('valodas.maina');
Route::get('valodas/{valoda}/tulkojums', [TulkojumsController::class, 'index'])->name('tulkojums.index');
Route::get('valodas/{valoda}/tulkojums/{original}/edit', [TulkojumsController::class, 'edit'])->name('tulkojums.edit');
Route::put('valodas/{valoda}/tulkojums/{original}', [TulkojumsController::class, 'update'])->name('tulkojums.update');

// API
Route::get('/request-access', [ApiAccessController::class, 'showForm']);
Route::post('/request-access', [ApiAccessController::class, 'requestAccess'])->name('request.access.submit');
Route::get('/api-requests', [ApiAccessController::class, 'index'])->name('api.requests')->middleware('permission:parvaldit_api');
Route::post('/api/delete-key/{id}', [ApiAccessController::class, 'deleteKey'])->middleware(['permission:parvaldit_api'])->name('api.key.delete');
Route::post('/api/block-device/{id}', [ApiAccessController::class, 'blockDevice'])->middleware(['permission:parvaldit_api'])->name('api.device.block');
Route::post('/api/approve-access/{request}', [ApiAccessController::class, 'approveAccess'])->middleware('permission:parvaldit_api');
Route::post('/api/deny-access/{request}', [ApiAccessController::class, 'denyAccess'])->middleware('permission:parvaldit_api');
Route::post('/api/unblock-device/{id}', [ApiAccessController::class, 'unblockDevice'])->middleware(['permission:parvaldit_api'])->name('api.device.unblock');

require __DIR__.'/auth.php';
