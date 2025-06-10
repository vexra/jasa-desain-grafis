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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pelanggan yang memesan
            $table->string('order_number')->unique(); // Nomor pesanan unik (bisa auto-generated)
            $table->decimal('total_amount', 10, 2); // Total harga pesanan
            $table->string('status')->default('pending'); // Status pesanan (pending, processing, completed, cancelled)
            $table->boolean('is_paid')->default(false);
            $table->text('notes')->nullable(); // Catatan dari pelanggan atau admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
