<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Doctors
    Route::middleware('throttle:30,1')->group(function () {
        Route::get('/doctors', [DoctorController::class, 'index']);
    });

    // Appointments
    Route::post('/appointments', [AppointmentController::class, 'book']);
    Route::post('/appointments/{id}', [AppointmentController::class, 'cancel']);
    Route::post('/appointments/{id}/complete', [AppointmentController::class, 'complete']);

});
