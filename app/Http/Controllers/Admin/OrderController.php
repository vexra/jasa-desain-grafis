<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource (all orders).
     */
    public function index()
    {
        // Ambil semua pesanan dengan informasi user dan paginasi
        $orders = Order::with('user')->orderByDesc('created_at')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     * (Admin usually doesn't create orders directly, so this method might not be used).
     */
    public function create()
    {
        // return view('admin.orders.create'); // Anda bisa menghapus ini jika tidak diperlukan
        abort(404, 'Admin tidak membuat pesanan secara langsung.');
    }

    /**
     * Store a newly created resource in storage.
     * (Admin usually doesn't store orders directly, this is handled by customer side).
     */
    public function store(Request $request)
    {
        // Logic for storing an order would typically be in a Customer/CartController
        abort(404, 'Admin tidak menyimpan pesanan secara langsung.');
    }

    /**
     * Display the specified resource (order details).
     */
    public function show(Order $order)
    {
        // Load order with its items and the associated menu and user
        $order->load('items.menu', 'user');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource (primarily for changing status).
     */
    public function edit(Order $order)
    {
        $order->load('items.menu', 'user'); // Load data yang diperlukan untuk edit
        $statuses = ['pending', 'processing', 'completed', 'cancelled']; // Daftar status yang mungkin
        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}