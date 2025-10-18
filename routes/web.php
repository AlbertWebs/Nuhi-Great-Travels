<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\BookingController;
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
use App\Http\Controllers\Admin\KycController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\SmileController;

use App\Http\Controllers\SubscriberPostController;


use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services/{slug}', [HomeController::class, 'services_single'])->name('services-single');

Route::get('/fleet', [HomeController::class, 'single_fleet'])->name('single_fleet_each');
Route::get('/fleet/{slug}', [HomeController::class, 'show_fleet'])->name('single_fleet');
Route::get('/fleet/{car}/{fleet}', [HomeController::class, 'show_single_fleets'])->name('single_fleets');


Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact-us');
Route::get('/updates', [HomeController::class, 'updates'])->name('updates');
Route::get('/updates/{slung}', [HomeController::class, 'show'])->name('blogs.show');

Route::post('/send-message', [HomeController::class, 'contactFormSubmit'])->name('contact.submit');
Route::post('/subscribe/ajax', [SubscriberPostController::class, 'ajaxStore'])->name('subscribe.ajax');

//KYC
Route::get('/kyc/start/{token}', [KycController::class, 'showPublicForm'])->name('kyc.public.start');
Route::post('/kyc/submit', [KycController::class, 'storePublic'])->name('kyc.public.store');
Route::view('/kyc/thankyou', 'kyc.thankyou')->name('kyc.thankyou');

// temporary
Route::get('fleets/generate-slugs', [HomeController::class, 'generateSlugs'])
    ->name('admin.fleets.generateSlugs');

Route::post('/kyc/liveliness/upload', [KycController::class, 'uploadLiveliness'])->name('kyc.liveliness.upload');
Route::get('/smile/init', [SmileController::class, 'init'])->name('smile.init');
//
Route::prefix('bookings')->group(function () {
    Route::get('/step1', [BookingController::class, 'step1'])->name('bookings.step1');
    Route::post('/step1', [BookingController::class, 'storeStep1'])->name('bookings.storeStep1');

    Route::get('/step2', [BookingController::class, 'step2'])->name('bookings.step2');
    Route::post('/step2', [BookingController::class, 'storeStep2'])->name('bookings.storeStep2');

    Route::get('/step3', [BookingController::class, 'step3'])->name('bookings.step3');
    Route::post('/complete', [BookingController::class, 'complete'])->name('bookings.complete');
});

Route::post('/kyc/smileid/callback', [KycController::class, 'smileIdCallback'])->name('kyc.smileid.callback');

// Payment Page
Route::get('/payment/{invoice}', [App\Http\Controllers\PaymentController::class, 'showPaymentPage'])
    ->name('frontend.payment.show');

Route::post('/payment/{invoice}/confirm', [App\Http\Controllers\PaymentController::class, 'processPayment'])
    ->name('frontend.payment.process');

Route::get('/payment/callback', [App\Http\Controllers\PaymentController::class, 'paymentCallback'])
     ->name('frontend.payment.callback');

Route::get('/payment/thank-you', function () {
    return view('frontend.payment.thankyou');
})->name('frontend.payment.thankyou');

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
    Route::resource('clients', App\Http\Controllers\Admin\ClientController::class)->names('clients');


    // Bookings CRUD
    Route::resource('bookings', BookingController::class);

    Route::resource('users', App\Http\Controllers\Admin\UserController::class);

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
    Route::get('/kyc', [KycController::class, 'index'])->name('kyc.index');
    Route::get('/kyc/create', [KycController::class, 'create'])->name('kyc.create');
    Route::post('/kyc', [KycController::class, 'store'])->name('kyc.store');
    Route::get('/kyc/{kyc}', [KycController::class, 'show'])->name('kyc.show');
    Route::put('/kyc/{kyc}/status', [KycController::class, 'updateStatus'])->name('kyc.updateStatus');
    Route::post('/kyc/liveliness/upload', [KycController::class, 'uploadLiveliness'])->name('kyc.liveliness.upload');


    // NEW: Subscribers
    Route::resource('subscribers', App\Http\Controllers\Admin\SubscriberController::class);

    // NEW: SMS
    Route::resource('sms', App\Http\Controllers\Admin\SmsController::class);

    // NEW: Client Feedbacks
    Route::resource('feedbacks', App\Http\Controllers\Admin\FeedbackController::class);

    // NEW: Blog
    Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class);

    // NEW: Notifications
    Route::resource('notifications', \App\Http\Controllers\Admin\NotificationController::class);

    Route::get('/legals', [LegalController::class, 'index'])->name('legals.index');
    Route::get('/legals/{page}/edit', [LegalController::class, 'edit'])->name('legals.edit');
    Route::put('/legals/{page}', [LegalController::class, 'update'])->name('legals.update');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');

    Route::resource('carousel', CarouselController::class)->names('carousel');

    // Admin routes (you can protect them with middleware)
    Route::get('/about/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('/about/update', [AboutController::class, 'update'])->name('about.update');

    Route::resource('faq', FaqController::class)->names('faq');
    Route::resource('fleets', FleetController::class)->names('fleets');

    Route::resource('services', ServiceController::class)->names('services');


    Route::prefix('billing')->group(function () {
        // Create Invoice Page
        Route::get('/create', [App\Http\Controllers\Admin\InvoiceController::class, 'create'])
            ->name('invoices.create');

        Route::get('/index', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])
            ->name('invoices.index');
        Route::get('/invoices/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'show'])
            ->name('invoices.show');

        Route::get('/invoices/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit'); // 👈 add this
        Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
        Route::post('/invoices/{id}/send-sms', [InvoiceController::class, 'sendSms'])
        ->name('invoices.send-sms');


        // Store Invoice
        Route::post('/store', [App\Http\Controllers\Admin\InvoiceController::class, 'store'])
            ->name('invoices.store');

        // Payments List Page
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])
            ->name('payments.index');

        // Payment Details (optional)
        Route::get('/payments/{id}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])
            ->name('payments.show');
    });

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
