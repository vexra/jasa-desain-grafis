<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource (all payments).
     */
    public function index()
    {
        // Ambil semua pembayaran dengan informasi order dan user terkait, paginasi
        $payments = Payment::with('order.user')->orderByDesc('created_at')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     * (Admin usually doesn't create payments directly).
     */
    public function create()
    {
        // return view('admin.payments.create'); // Anda bisa menghapus ini jika tidak diperlukan
        abort(404, 'Admin tidak membuat pembayaran secara langsung.');
    }

    /**
     * Store a newly created resource in storage.
     * (Admin usually doesn't store payments directly, this is handled by customer side/payment gateway).
     */
    public function store(Request $request)
    {
        // Logic for storing a payment would typically be integrated with payment gateway callbacks
        abort(404, 'Admin tidak menyimpan pembayaran secara langsung.');
    }

    /**
     * Display the specified resource (payment details).
     */
    public function show(Payment $payment)
    {
        // Load payment with its associated order and user
        $payment->load('order.user');
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource (primarily for changing status).
     */
    public function edit(Payment $payment)
    {
        $payment->load('order.user'); // Load data yang diperlukan untuk edit
        $statuses = ['pending', 'completed', 'failed', 'refunded']; // Daftar status yang mungkin
        return view('admin.payments.edit', compact('payment', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded',
            'notes' => 'nullable|string|max:1000',
            'transaction_id' => 'nullable|string|max:255|unique:payments,transaction_id,' . $payment->id,
            'method' => 'nullable|string|max:255',
        ]);

        $payment->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'transaction_id' => $request->transaction_id,
            'method' => $request->method,
            'paid_at' => ($request->status === 'completed' && !$payment->paid_at) ? now() : $payment->paid_at,
        ]);

        // Opsional: Jika status berubah menjadi 'completed', Anda mungkin ingin mengupdate status pesanan terkait
        if ($payment->status === 'completed' && $payment->order->status === 'pending') {
            $payment->order->update(['status' => 'processing']);
        }

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dihapus!');
    }
}