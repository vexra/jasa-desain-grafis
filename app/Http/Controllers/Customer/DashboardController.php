<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Mengimpor model Order

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index()
    {
        // Ambil pesanan terbaru untuk user yang sedang login
        $latestOrders = auth()->user()->orders()->orderByDesc('created_at')->limit(5)->get();

        // Ambil statistik pesanan pelanggan
        $totalOrders = auth()->user()->orders()->count();
        $pendingOrders = auth()->user()->orders()->where('status', 'pending')->count();
        $completedOrders = auth()->user()->orders()->where('status', 'completed')->count();

        // Anda bisa menambahkan logika lain di sini, misal:
        // total_amount_spent = auth()->user()->orders()->where('status', 'completed')->sum('total_amount');

        return view('customer.dashboard', compact('latestOrders', 'totalOrders', 'pendingOrders', 'completedOrders'));
    }
}