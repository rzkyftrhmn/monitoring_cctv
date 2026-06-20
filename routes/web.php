<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrafficController;

Route::get('/', [TrafficController::class, 'index']);
Route::get('/api/traffic', [TrafficController::class, 'apiIndex']);
