<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App\HomeController;
use App\Http\Controllers\App\EventController;
use App\Http\Controllers\App\BookingController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\PaymentSettingController;
use App\Http\Controllers\App\SubscriptionPlanController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
 
    Route::get('/', [HomeController::class, 'index'])->name('home');

    
    Route::middleware('auth')->group(function () {


        
        Route::get('/dashboard', function () {
            return view('app.dashboard');
        })->middleware(['verified'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     
        Route::middleware(['tenantAdmin'])->group(function () {
            Route::middleware(['CheckSubscriptionLimits'])->group(function () {
                Route::resource('events', EventController::class);
            });

            Route::get('/payment-settings', [PaymentSettingController::class, 'index'])->name('payment-settings.index');
            Route::put('/payment-settings', [PaymentSettingController::class, 'update'])->name('payment-settings.update');
        
            Route::get('/plans', [SubscriptionPlanController::class, 'index'])->name('plan');
            Route::get('/subscribe-plans/{id}', [SubscriptionPlanController::class, 'subscribe'])->name('subscribe.plan');
            Route::post('/checkout/process', [SubscriptionPlanController::class, 'processPayment'])->name('checkout.process');

            Route::get('/view-bookings/{id}', [EventController::class, 'viewBooking'])->name('view.booking');

        });


        Route::middleware('tenantUser')->group(function () {
            Route::get('/events/book/{id}', [BookingController::class, 'create'])->name('bookings.create'); // Show booking form
            Route::get('/free-events/book/{id}', [BookingController::class, 'freeBooking'])->name('free.bookings.store'); // Process payment and store booking
            Route::post('/paid-events/book/{id}', [BookingController::class, 'store'])->name('bookings.store'); // Process payment and store booking
            Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my.bookings'); // Booking success page
        });

    });
 
    require __DIR__.'/tenant-auth.php';



});
