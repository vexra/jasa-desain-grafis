<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total statistik
        $totalMenus = Menu::count();
        $totalCustomers = User::where('role', 'pelanggan')->count();
        $totalOrders = Order::count();
        $totalPayments = Payment::where('status', 'completed')->sum('amount');

        // Statistik pesanan berdasarkan status
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Statistik pembayaran
        $pendingPayments = Payment::where('status', 'pending')->count();
        $completedPaymentsCount = Payment::where('status', 'completed')->count();
        $failedPayments = Payment::where('status', 'failed')->count();

        return view('admin.dashboard', compact(
            'totalMenus',
            'totalCustomers',
            'totalOrders',
            'totalPayments',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'pendingPayments',
            'completedPaymentsCount',
            'failedPayments'
        ));
    }
}