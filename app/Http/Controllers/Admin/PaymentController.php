<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index()
    {
        $payments = Payment::with('order.user')->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $payment->load('order.user'); // Load relasi order dan user
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Approve the specified payment and update associated order.
     */
    public function approve(Payment $payment)
    {
        if ($payment->status === 'completed') {
            return redirect()->back()->with('error', 'Pembayaran ini sudah dikonfirmasi.');
        }

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // Update status pesanan terkait
            $order = $payment->order;
            if ($order->status === 'pending' || $order->status === 'cancelled') { // Hanya update jika statusnya masih pending atau cancelled
                $order->update([
                    'status' => 'processing', // Atau 'completed' jika tidak ada proses setelah pembayaran
                    'is_paid' => true,
                ]);
            }
        });

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dikonfirmasi dan status pesanan diperbarui.');
    }

    /**
     * Reject the specified payment.
     */
    public function reject(Payment $payment)
    {
        if ($payment->status === 'failed') {
            return redirect()->back()->with('error', 'Pembayaran ini sudah ditolak.');
        }

        DB::transaction(function () use ($payment) {
            $payment->update([
                'status' => 'failed',
                'notes' => $payment->notes . "\n(Rejected by admin at " . now()->format('d M Y H:i') . ")",
            ]);

            // Opsional: Anda bisa mengubah status order menjadi 'cancelled' jika pembayaran ditolak
            // $order = $payment->order;
            // if ($order->status !== 'completed') {
            //     $order->update(['status' => 'cancelled']);
            // }
        });

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil ditolak.');
    }

    // Metode update, create, store, edit, destroy tidak perlu jika admin hanya approve/reject
    // public function update(Request $request, Payment $payment) { ... }
}