<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController as AdminMenuController; // Rename to avoid conflict
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController; // Import Customer Dashboard
use App\Http\Controllers\Customer\OrderController as CustomerOrderController; // For customer orders
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
        // Jika bukan admin, arahkan ke dashboard pelanggan
        return redirect()->route('customer.dashboard');
    })->name('dashboard'); // <-- Rute ini adalah rute umum 'dashboard'

    // Rute khusus untuk pelanggan
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('orders', CustomerOrderController::class)->only(['index', 'show']); // Pelanggan bisa melihat pesanannya
       
        Route::get('/menus', [CustomerMenuController::class, 'index'])->name('menus.index'); // Daftar menu
        Route::get('/menus/{menu}', [CustomerMenuController::class, 'show'])->name('menus.show'); // Detail menu (opsional)
        Route::post('/menus/{menu}/order', [CustomerMenuController::class, 'orderNow'])->name('menus.orderNow');

        Route::post('/orders/{order}/pay', [CustomerOrderController::class, 'markAsPaid'])->name('orders.markAsPaid');
    });
});


// Rute khusus untuk Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Rute dashboard admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rute CRUD untuk Menu
    Route::resource('menus', AdminMenuController::class);

    // Rute CRUD untuk Pesanan
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);

    // Rute CRUD untuk Pelanggan
    Route::resource('customers', CustomerController::class)->except(['create', 'store']);

    // Rute CRUD untuk Pembayaran
    Route::resource('payments', AdminPaymentController::class)->except(['create', 'store']);
});


// Rute Publik (Landing Page, dll)
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';