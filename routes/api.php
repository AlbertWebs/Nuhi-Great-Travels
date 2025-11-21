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
    // API info endpoint
    Route::get('/', function () {
        return response()->json([
            'success' => true,
            'message' => 'Nuhi Great Travels API v1',
            'version' => '1.0.0',
            'endpoints' => [
                'GET /api/v1/settings' => 'Get app settings',
                'GET /api/v1/cars' => 'Get car categories',
                'GET /api/v1/fleets' => 'Get vehicles',
                'GET /api/v1/fleets/{id}' => 'Get vehicle details',
                'POST /api/v1/bookings' => 'Create booking',
                'GET /api/v1/bookings/{id}' => 'Get booking details',
                'POST /api/v1/calculate-price' => 'Calculate booking price',
                'POST /api/v1/register' => 'Register user',
                'POST /api/v1/login' => 'Login user',
                'POST /api/v1/google-login' => 'Google login',
            ]
        ]);
    });
    
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
    
    // Error logging
    Route::post('/log-error', [ApiController::class, 'logError']);
    
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

