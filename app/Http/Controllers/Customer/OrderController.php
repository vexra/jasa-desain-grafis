<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ganti .get() dengan .paginate()
        // Anda bisa menentukan jumlah item per halaman, misalnya 10
        $orders = Auth::user()->orders()->latest()->paginate(10); // Ambil pesanan user yang login dengan pagination

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Pastikan pesanan ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan relasi items diload
        // Catatan: Relasi di model Order harus bernama 'items', bukan 'items'
        $order->load('items.menu'); // <-- Pastikan ini sesuai dengan nama relasi di model Order

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Mark the specified order as paid and update its status.
     * This is a simplified payment process.
     */
    public function markAsPaid(Order $order)
    {
        // Pastikan pesanan ini milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak melakukan aksi ini.');
        }

        // Cek jika pesanan sudah dibayar atau tidak dalam status 'pending'
        if ($order->is_paid || $order->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan ini tidak bisa dibayar atau sudah selesai.');
        }

        // Update status dan is_paid
        $order->update([
            'status' => 'completed', // Atau 'processing' jika ada langkah setelah pembayaran
            'is_paid' => true,
        ]);

        // Anda bisa menambahkan logika lain di sini, seperti:
        // - Membuat entri di tabel `payments` (jika ada)
        // - Mengirim notifikasi ke admin
        // - Mengurangi stok barang (jika ada)

        return redirect()->route('customer.orders.show', $order)
                         ->with('success', 'Pesanan Anda telah berhasil dibayar dan status diperbarui!');
    }
}