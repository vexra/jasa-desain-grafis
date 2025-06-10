<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;    // Import model Order
use App\Models\OrderItem; // Import model OrderItem
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login

class MenuController extends Controller
{
    /**
     * Display a listing of the menus/services available for customers.
     */
    public function index()
    {
        $menus = Menu::all(); // Mengambil semua menu

        return view('customer.menus.index', compact('menus'));
    }

    /**
     * Display the specified menu/service.
     */
    public function show(Menu $menu)
    {
        return view('customer.menus.show', compact('menu'));
    }

    /**
     * Handle the "Pesan Sekarang" action. Creates an order directly.
     */
    public function orderNow(Request $request, Menu $menu)
    {
        $user = Auth::user();

        // Validasi kuantitas jika ada input kuantitas di form (misal dari halaman detail)
        $quantity = $request->input('quantity', 1); // Default quantity is 1

        if ($quantity <= 0) {
            return redirect()->back()->with('error', 'Kuantitas tidak valid.');
        }

        // 1. Buat pesanan baru
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $menu->price * $quantity, // Total langsung dari harga menu * kuantitas
            'status' => 'pending', // Status awal pesanan
            // 'shipping_address' => $user->address, // Opsional: ambil dari profil user jika ada
        ]);

        // 2. Tambahkan item ke pesanan
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $menu->id,
            'quantity' => $quantity,
            'price' => $menu->price, // Simpan harga menu saat dipesan
        ]);

        return redirect()->route('customer.orders.show', $order)
                         ->with('success', 'Pesanan Anda dengan nomor ' . $order->order_number . ' telah berhasil dibuat!');
    }
}