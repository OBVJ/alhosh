<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API routes for car operations (no authentication required for basic operations)
Route::prefix('cars')->group(function () {
    // Get all cars
    Route::get('/', [CarController::class, 'apiIndex']);

    // Search car by chassis number
    Route::get('/search', [CarController::class, 'apiSearch']);

    // Get specific car by ID
    Route::get('/{id}', [CarController::class, 'apiShow']);
});

// Protected API routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admin/cars')->group(function () {
        // Create new car
        Route::post('/', [CarController::class, 'apiStore']);

        // Update car
        Route::put('/{id}', [CarController::class, 'apiUpdate']);

        // Delete car
        Route::delete('/{id}', [CarController::class, 'apiDestroy']);
    });
});

// API routes for police stations
Route::prefix('police-stations')->group(function () {
    Route::get('/', [AdminController::class, 'apiPoliceStations']);
});
