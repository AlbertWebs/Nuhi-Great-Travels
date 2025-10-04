<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FleetController;
use App\Http\Controllers\Admin\LegalController;
use App\Http\Controllers\Admin\ServiceController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services/{slug}', [HomeController::class, 'services_single'])->name('services-single');

Route::get('/our-fleet', [HomeController::class, 'fleet'])->name('fleet');
Route::get('/our-fleet/{slung}', [HomeController::class, 'single_fleet'])->name('single_fleet');

// ====================
// ADMIN AUTH
// ====================
Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.attempt');
Route::post('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ====================
// PROTECTED ADMIN AREA
// ====================
Route::middleware(['auth','is_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // About Us (simple info/editable)
    Route::get('/about', [AboutController::class, 'index'])->name('about');

    // Cars CRUD
    Route::resource('cars', CarController::class)->names('cars');

    // Clients CRUD
    Route::resource('clients', ClientController::class);

    // Bookings CRUD
    Route::resource('bookings', BookingController::class);

    // Payments CRUD
    Route::resource('payments', PaymentController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Users management
    Route::resource('users', UserController::class);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

      // Payments
    Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('/mpesa', [PaymentController::class, 'mpesa'])->name('mpesa');
    Route::get('/card', [PaymentController::class, 'card'])->name('card');
    Route::get('/crypto', [PaymentController::class, 'crypto'])->name('crypto');
    });
       // NEW: KYC
    Route::resource('kyc', App\Http\Controllers\Admin\KycController::class);

    // NEW: Subscribers
    Route::resource('subscribers', App\Http\Controllers\Admin\SubscriberController::class);

    // NEW: SMS
    Route::resource('sms', App\Http\Controllers\Admin\SmsController::class);

    // NEW: Client Feedbacks
    Route::resource('feedbacks', App\Http\Controllers\Admin\FeedbackController::class);

    // NEW: Notifications
    Route::resource('notifications', App\Http\Controllers\Admin\NotificationController::class);

   Route::get('/terms', [LegalController::class, 'terms'])->name('legal.terms');
   Route::get('/privacy', [LegalController::class, 'privacy'])->name('legal.privacy');
   Route::get('/booking', [LegalController::class, 'booking'])->name('legal.booking');
   Route::get('/copyright', [LegalController::class, 'copyright'])->name('legal.copyright');
   //

    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

    Route::resource('carousel', CarouselController::class)->names('carousel');

    // Admin routes (you can protect them with middleware)
    Route::get('/about/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('/about/update', [AboutController::class, 'update'])->name('about.update');

    Route::resource('faq', FaqController::class)->names('faq');
    Route::resource('fleets', FleetController::class)->names('fleets');

    Route::resource('services', ServiceController::class)->names('services');


});

// ====================
// USER AREA
// ====================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
