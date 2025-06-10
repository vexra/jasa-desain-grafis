<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Rute dashboard admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Gunakan tampilan dashboard admin Anda
    })->name('dashboard');

    // Rute CRUD untuk Menu
    Route::resource('menus', MenuController::class);

    // Rute CRUD untuk Pesanan
    Route::resource('orders', OrderController::class)->except(['create', 'store']); // Admin tidak membuat pesanan

    // Rute CRUD untuk Pelanggan
    Route::resource('customers', CustomerController::class)->except(['create', 'store']); // Admin tidak membuat pelanggan

    // Rute CRUD untuk Pembayaran
    Route::resource('payments', PaymentController::class)->except(['create', 'store']); // Admin tidak membuat pembayaran secara manual
});

Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
});

Route::get('/redirect-after-login', function () {
    $role = auth()->user()->role;
    return match ($role) {
        'pelanggan' => redirect()->route('dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        default => abort(403),
    };
});

require __DIR__.'/auth.php';
