<?php

use App\Http\Controllers\API\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PassportAuthController;

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);



Route::middleware('auth:api')->group(function () {
    Route::get('logout', [PassportAuthController::class, 'logout']);
    Route::get('get-user', [PassportAuthController::class, 'userInfo']);
    Route::get('get-available-seats', [BookingController::class, 'getAvailableSeats']);
    Route::post('booking-seat', [BookingController::class, 'booking']);
});
