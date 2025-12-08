<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAccessController;

Route::get('/request-access', [ApiAccessController::class, 'requestAccess']);
Route::get('/get-pieturas', [ApiAccessController::class, 'getPieturas'])->middleware('check.api.key'); 
