<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}/edit', [UserController::class, 'edit']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::get('/appointments', [AppointmentController::class, 'index']);
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
Route::put('/appointments/{appointment}', [AppointmentController::class, 'update']);
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);


