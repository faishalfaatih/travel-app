<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TravelScheduleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;

RateLimiter::for('api', function (Request $request) {
    return \Illuminate\Cache\RateLimiting\Limit::perMinute(60);
});

Route::middleware('throttle:api')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin-dashboard', function () {
            return response()->json(['message' => 'Welcome Admin']);
        });
        Route::get('/travel-schedules', [TravelScheduleController::class, 'index']);
        Route::post('/travel-schedules', [TravelScheduleController::class, 'store']);
        Route::get('/travel-schedules/{id}', [TravelScheduleController::class, 'show']);
        Route::put('/travel-schedules/{id}', [TravelScheduleController::class, 'update']);
        Route::delete('/travel-schedules/{id}', [TravelScheduleController::class, 'destroy']);
        Route::get('/report/passengers/{id}', [ReportController::class, 'passengersPerTravel']);
        Route::get('/report/passenger-list/{id}', [ReportController::class, 'passengerList']);
    });

    Route::middleware('role:penumpang')->group(function () {
        Route::get('/penumpang-dashboard', function () {
            return response()->json(['message' => 'Welcome Penumpang']);
        });
        Route::get('/available-travel-schedules', [TravelScheduleController::class, 'availableSchedules']);
        Route::post('/book-ticket', [ReservationController::class, 'bookTicket']);
        Route::get('/booking-history', [ReservationController::class, 'bookingHistory']);
    });
});