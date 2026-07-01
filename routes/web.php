<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrafficController;

Route::get('/', [TrafficController::class, 'index']);
Route::get('/api/traffic', [TrafficController::class, 'apiIndex']);
Route::get('/api/traffic-priorities', [TrafficController::class, 'priorities']);
Route::get('/api/traffic-history/{key}', [TrafficController::class, 'history']);
Route::get('/api/traffic-insight/{key}', [TrafficController::class, 'insight']);
