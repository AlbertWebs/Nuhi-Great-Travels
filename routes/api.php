<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserAccountController;
use App\Http\Controllers\Api\GoogleAuthController;

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

// Public API routes
Route::prefix('v1')->group(function () {
    // Settings
    Route::get('/settings', [ApiController::class, 'getSettings']);
    
    // Cars (categories)
    Route::get('/cars', [ApiController::class, 'getCars']);
    
    // Fleets (vehicles)
    Route::get('/fleets', [ApiController::class, 'getFleets']);
    Route::get('/fleets/{id}', [ApiController::class, 'getFleet']);
    
    // Bookings (public - creates user if needed)
    Route::post('/bookings', [ApiController::class, 'createBooking']);
    Route::get('/bookings/{id}', [ApiController::class, 'getBooking']);
    
    // Calculate price
    Route::post('/calculate-price', [ApiController::class, 'calculatePrice']);
    
    // Authentication
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/google-login', [GoogleAuthController::class, 'login']);
    
    // Protected routes (require authentication)
    Route::middleware('api.auth')->group(function () {
        // Auth routes
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // User account routes
        Route::get('/my-bookings', [UserAccountController::class, 'getBookings']);
        Route::get('/my-invoices', [UserAccountController::class, 'getInvoices']);
        Route::get('/my-payments', [UserAccountController::class, 'getPayments']);
        Route::get('/loyalty-points', [UserAccountController::class, 'getLoyaltyPoints']);
    });
});

