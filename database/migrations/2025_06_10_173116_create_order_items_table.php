<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Terhubung ke tabel orders
            $table->foreignId('menu_id')->constrained()->onDelete('cascade'); // Terhubung ke tabel menus (jasa yang dipesan)
            $table->integer('quantity'); // Jumlah item (misal: 1 desain logo)
            $table->decimal('price', 10, 2); // Harga per item saat dipesan (penting karena harga menu bisa berubah)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
