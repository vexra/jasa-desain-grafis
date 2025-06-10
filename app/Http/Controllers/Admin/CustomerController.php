<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Menggunakan model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk hash password jika diizinkan admin meresetnya

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource (all customers/users with 'pelanggan' role).
     */
    public function index()
    {
        // Ambil hanya user dengan role 'pelanggan'
        $customers = User::where('role', 'pelanggan')->orderBy('name')->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     * (Admin biasanya tidak membuat pelanggan baru secara langsung melalui panel ini.
     * Pelanggan mendaftar sendiri).
     */
    public function create()
    {
        // return view('admin.customers.create'); // Anda bisa mengaktifkan ini jika ingin admin bisa mendaftarkan pelanggan
        abort(404, 'Admin tidak membuat pelanggan baru secara langsung.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Logic for storing a new customer (if create method is enabled)
        abort(404, 'Admin tidak menyimpan pelanggan baru secara langsung.');
    }

    /**
     * Display the specified resource (customer details).
     */
    public function show(User $customer) // Menggunakan type-hint User karena kita memanipulasi user
    {
        // Pastikan hanya user dengan role 'pelanggan' yang bisa diakses
        if ($customer->role !== 'pelanggan') {
            abort(403, 'Anda tidak memiliki akses ke data user ini.');
        }

        // Load pesanan terkait pelanggan
        $customer->load('orders');

        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource (customer profile).
     */
    public function edit(User $customer) // Menggunakan type-hint User
    {
        if ($customer->role !== 'pelanggan') {
            abort(403, 'Anda tidak memiliki akses untuk mengedit user ini.');
        }
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer) // Menggunakan type-hint User
    {
        if ($customer->role !== 'pelanggan') {
            abort(403, 'Anda tidak memiliki akses untuk memperbarui user ini.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            // 'password' => 'nullable|string|min:8|confirmed', // Jika admin bisa mengubah password
        ];

        $request->validate($rules);

        $customer->name = $request->name;
        $customer->email = $request->email;
        // Jika ingin admin bisa mengubah role, hati-hati!
        // $customer->role = $request->role; // Tambahkan validasi jika ini diaktifkan

        // Jika ada password baru, hash dan simpan
        // if ($request->filled('password')) {
        //     $customer->password = Hash::make($request->password);
        // }

        $customer->save();

        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer) // Menggunakan type-hint User
    {
        // Pastikan admin tidak bisa menghapus dirinya sendiri atau user dengan role admin lainnya
        if ($customer->id === auth()->id() || $customer->role === 'admin') {
            return redirect()->route('admin.customers.index')->with('error', 'Anda tidak dapat menghapus user ini.');
        }

        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}