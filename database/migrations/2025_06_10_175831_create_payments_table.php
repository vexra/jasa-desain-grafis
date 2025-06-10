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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Terhubung ke tabel orders
            $table->string('transaction_id')->nullable()->unique(); // ID transaksi dari gateway pembayaran
            $table->decimal('amount', 10, 2); // Jumlah pembayaran
            $table->string('method')->nullable(); // Metode pembayaran (misal: Bank Transfer, E-wallet)
            $table->string('status')->default('pending'); // Status pembayaran (pending, completed, failed, refunded)
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamp('paid_at')->nullable(); // Waktu pembayaran dikonfirmasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
