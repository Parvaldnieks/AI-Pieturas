<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAccessController;

Route::get('/get-pieturas', [ApiAccessController::class, 'getPieturas'])->middleware('check.api.key');
