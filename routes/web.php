<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\MenuController as CustomerMenuController;

// Rute untuk user yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard umum untuk semua user yang sudah login
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('customer.dashboard');
    })->name('dashboard');

    // Rute khusus untuk pelanggan
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('orders', CustomerOrderController::class)->only(['index', 'show']);

        // Rute BARU untuk proses pembayaran oleh pelanggan
        Route::get('/orders/{order}/pay', [CustomerOrderController::class, 'createPayment'])->name('orders.createPayment');
        Route::post('/orders/{order}/pay', [CustomerOrderController::class, 'storePayment'])->name('orders.storePayment');

        // Rute untuk menu/layanan pelanggan
        Route::get('/menus', [CustomerMenuController::class, 'index'])->name('menus.index');
        Route::get('/menus/{menu}', [CustomerMenuController::class, 'show'])->name('menus.show');
        Route::post('/menus/{menu}/order', [CustomerMenuController::class, 'orderNow'])->name('menus.orderNow');
    });
});


// Rute khusus untuk Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('menus', AdminMenuController::class);
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);

    // Rute Admin untuk manajemen pembayaran
    Route::resource('payments', AdminPaymentController::class)->only(['index', 'show', 'update']); // Admin hanya update status
    Route::post('payments/{payment}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    Route::post('payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

    Route::resource('customers', CustomerController::class)->except(['create', 'store']);
});


// Rute Publik (Landing Page, dll)
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';