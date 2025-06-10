<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = auth()->user()->orders()->orderByDesc('created_at')->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Pastikan pesanan ini milik user yang sedang login
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.menu'); // Muat item pesanan dan menu terkait
        return view('customer.orders.show', compact('order'));
    }
}