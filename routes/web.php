<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PaymentSettingController;
use App\Http\Controllers\TenantRegisterController;
use App\Http\Controllers\SubscriptionPlanController;
 

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {


    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 
    Route::resource('subscription-plans', SubscriptionPlanController::class);
    Route::get('tenant-index', [TenantController::class, 'index'])->name('tenants.index');

    Route::get('/payment-settings', [PaymentSettingController::class, 'index'])->name('payment-settings.index');
    Route::put('/payment-settings', [PaymentSettingController::class, 'update'])->name('payment-settings.update');

    // Route::get('stripe/payment', [StripePaymentController::class, 'showPaymentForm'])->name('stripe.payment.form');
    // Route::post('stripe/payment', [StripePaymentController::class, 'processPayment'])->name('stripe.payment');

});

Route::get('tenant-register', [TenantRegisterController::class, 'register'])->name('tenant.register');
Route::post('tenant-store', [TenantRegisterController::class, 'store'])->name('tenant.store');

require __DIR__.'/auth.php';

 