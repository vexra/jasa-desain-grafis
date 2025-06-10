<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment; // Import model Payment
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('items.menu', 'payments'); // Load payments juga
        return view('customer.orders.show', compact('order'));
    }

    // --- Metode BARU untuk pembayaran ---

    /**
     * Show the form for creating a new payment for an order.
     */
    public function createPayment(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Cek apakah pesanan sudah completed/cancelled atau sudah memiliki pembayaran pending/completed
        if ($order->status !== 'pending' || $order->is_paid || $order->payments()->whereIn('status', ['pending', 'completed'])->exists()) {
            return redirect()->route('customer.orders.show', $order)
                             ->with('error', 'Pesanan ini tidak memenuhi syarat untuk pembayaran baru.');
        }

        return view('customer.orders.create-payment', compact('order'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function storePayment(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Cek kembali status pesanan sebelum menyimpan pembayaran
        if ($order->status !== 'pending' || $order->is_paid || $order->payments()->whereIn('status', ['pending', 'completed'])->exists()) {
            return redirect()->route('customer.orders.show', $order)
                             ->with('error', 'Tidak dapat memproses pembayaran untuk pesanan ini.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $order->total_amount, // Pastikan jumlah tidak lebih dari total
            'method' => 'required|string|in:Bank Transfer,E-wallet,Credit Card', // Contoh metode
            'proof_of_payment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Bukti transfer (opsional, bisa disesuaikan)
            'notes' => 'nullable|string|max:500',
        ]);

        $proofPath = null;
        if ($request->hasFile('proof_of_payment')) {
            $proofPath = $request->file('proof_of_payment')->store('payment_proofs', 'public');
        }

        Payment::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(), // Simpan user_id yang membuat payment
            'amount' => $request->amount,
            'method' => $request->method,
            'proof_of_payment' => $proofPath,
            'status' => 'pending', // Status awal pembayaran selalu pending
            'notes' => $request->notes,
            'transaction_id' => 'PAY-' . time() . '-' . uniqid(), // ID transaksi sederhana
        ]);

        return redirect()->route('customer.orders.show', $order)
                         ->with('success', 'Pengajuan pembayaran Anda telah diterima. Mohon tunggu konfirmasi dari admin.');
    }

    // Metode markAsPaid sebelumnya dihapus karena diganti dengan alur approval admin
    // public function markAsPaid(Order $order) { ... }
}