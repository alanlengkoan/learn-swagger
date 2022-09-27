<?php

use App\Http\Controllers\api\Employees;
use App\Http\Controllers\api\Overtimes;
use App\Http\Controllers\api\Settings;
use Illuminate\Support\Facades\Route;

// untuk settings
Route::put('/settings', [Settings::class, 'index']);
// untuk employees
Route::post('/employees', [Employees::class, 'index']);
// untuk overtimes
Route::post('/overtimes', [Overtimes::class, 'index']);
// untuk overtimes calculate
Route::get('/overtime-pays/calculate', [Overtimes::class, 'overtime_calculate']);
