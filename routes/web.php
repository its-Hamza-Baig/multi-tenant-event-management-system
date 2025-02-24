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
 
 
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {


    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function(){

        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
     
    });
    
    Route::prefix('payment-settings')->name('payment.settings.')->group(function(){

        Route::get('/', [PaymentSettingController::class, 'index'])->name('index');
        Route::put('/', [PaymentSettingController::class, 'update'])->name('update');
 
    });

    Route::resource('subscription-plans', SubscriptionPlanController::class);

    Route::get('tenant-list', [TenantController::class, 'index'])->name('tenants.index');

});

Route::get('tenant-register', [TenantRegisterController::class, 'register'])->name('tenant.register');
Route::post('tenant-store', [TenantRegisterController::class, 'store'])->name('tenant.store');

require __DIR__.'/auth.php';

 