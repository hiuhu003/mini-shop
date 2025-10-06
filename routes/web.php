<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\PickupStationController;


use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController  as UserOrderController; 

Route::get('/', [UserController::class, 'index'])->name('home');

Route::get('/dashboar', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Admin routes (ONE group, no nested admin/admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','verified','can:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Products (full CRUD except show)
        Route::resource('products', ProductController::class)
            ->except(['show']);

      
        Route::get('products/view', [ProductController::class, 'index'])
            ->name('products.view');

        // Reports
        Route::resource('reports', ReportController::class)->only(['index']);


        //pickup stations
        Route::resource('stations', PickupStationController::class)->only(['index','store','update','destroy']);


        // Settings
        Route::get('/settings', [SettingsController::class, 'show'])->name('settings');

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

        // Search
        Route::get('/search', [SearchController::class, 'index'])->name('search');
    });

// Optional: make /admin go to the dashboard
Route::redirect('/admin', '/admin/dashboard');

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::middleware('auth')->group(function () {
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

   // protect checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');
});


/*
|--------------------------------------------------------------------------
| Shop
|--------------------------------------------------------------------------
*/
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

/*
|--------------------------------------------------------------------------
| Orders (for users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show'); 

    Route::patch('/orders/{order}/cancel', [UserOrderController::class,'cancel'])
        ->name('orders.cancel');
});

/*
|--------------------------------------------------------------------------
| Orders (for admins)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','verified','can:admin'])
    ->group(function () {
        Route::resource('orders', AdminOrderController::class)->only(['index','show','update','destroy']);
    });

    //Contact page
    Route::view('/contact', 'user.contact')->name('user.contact');