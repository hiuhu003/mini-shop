<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;

Route::get('/', [UserController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//admin routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','verified','can:admin'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        //Products
        Route::prefix('admin')->name('admin.')->middleware(['auth','verified','can:admin'])->group(function () {
            Route::resource('products', ProductController::class)->only(['index','create','store']);
        });
    

        // Orders / Products / Customers / Reports
        Route::resource('orders', OrderController::class)->only(['index','show']);
        Route::resource('products', ProductController::class)->only(['index','create','store','edit','update','destroy']);
        Route::resource('customers', CustomerController::class)->only(['index','show']);
        Route::resource('reports', ReportController::class)->only(['index']);

        // Settings
        Route::get('/settings', [SettingsController::class, 'show'])
            ->name('settings');

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('notifications');

        // Search
        Route::get('/search', [SearchController::class, 'index'])
            ->name('search');
    });

// (Optional) Make /admin redirect to the dashboard
Route::redirect('/admin', '/admin/dashboard');


// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

//checkout routes
Route::post('/checkout', [CheckoutController::class, 'start'])->name('checkout.start');

//shop routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');