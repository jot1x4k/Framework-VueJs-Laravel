<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);
Route::get('/appointments', [AppointmentController::class, 'index']);

Route::post('/appointments', [AppointmentController::class, 'store']);

