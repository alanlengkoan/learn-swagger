<?php

use App\Http\Controllers\api\Overtime;
use Illuminate\Support\Facades\Route;

// untuk settings
Route::patch('/settings', [Overtime::class, 'settings']);
// untuk employees
Route::post('/employees', [Overtime::class, 'employees']);
// untuk overtimes
Route::post('/overtimes', [Overtime::class, 'overtimes']);
// untuk overtimes calculate
Route::get('/overtime-pays/calculate', [Overtime::class, 'overtime_calculate']);
