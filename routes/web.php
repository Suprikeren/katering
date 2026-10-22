<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController as customerProfile;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Merchant\InvoiceController;
use App\Http\Controllers\Dashboard\Merchant\MenuController;
use App\Http\Controllers\Dashboard\Merchant\OrderController as MerchantOrder;
use App\Http\Controllers\Dashboard\Merchant\ProfileController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SuperAdmin\MerchantController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/')->name('home.')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('caterings', 'caterings')->name('caterings');
        Route::get('menu/{id}', 'detailCatering')->name('detail-catering');
        // Route::get('cart', 'cart')->name('cart');
    });
    Route::controller(CartController::class)->middleware('auth')->group(function () {
        Route::get('cart', 'index')->name('cart');
        Route::post('cart', 'store')->name('cart.store');
        Route::put('cart/{id}', 'update')->name('cart.update');
        Route::delete('cart/{id}', 'destroy')->name('cart.destroy');
    });
    Route::controller(OrderController::class)->middleware('auth')->group(function () {
        Route::get('checkout', 'checkout')->name('checkout');
        Route::post('checkout', 'store')->name('checkout.store');
        Route::get('invoices', 'invoices')->name('invoices');
        Route::get('invoices/{id}', 'showInvoice')->name('invoices.show');
    });
    Route::controller(customerProfile::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::put('/profile', 'update')->name('profile.update');
    });


});

Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // super admin
    Route::controller(MerchantController::class)
            ->prefix('super-admin')
            ->name('super-admin.')
            ->group(function () {
                Route::get('/merchants', 'index')
                    ->name('merchants.index');
            });
    // super admin end
    Route::get('/', [DashboardController::class, 'index'])
        ->name('index');

    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{user}/edit', 'edit')->name('edit');
        Route::put('{user}', 'update')->name('update');
        Route::delete('{user}', 'destroy')->name('destroy');
    });

    Route::controller(RoleController::class)->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{role}/edit', 'edit')->name('edit');
        Route::put('{role}', 'update')->name('update');
        Route::delete('{role}', 'destroy')->name('destroy');
    });

    Route::controller(PermissionController::class)->prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('{permission}', 'update')->name('update');
        Route::delete('{permission}', 'destroy')->name('destroy');
    });

    Route::prefix('merchant')->name('merchant.')->group(function () {
        Route::resource('menus', MenuController::class);
        Route::controller(MerchantOrder::class)
            ->prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
                Route::patch('/{id}/status', 'updateStatus')
                    ->name('update-status');
            });
        Route::controller(InvoiceController::class)
            ->prefix('invoices')
            ->name('invoices.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
            });

        Route::controller(ProfileController::class)
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::put('/', 'update')->name('update');
    });
    });

});
