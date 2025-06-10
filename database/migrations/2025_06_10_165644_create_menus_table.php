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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama jasa/menu (contoh: Desain Logo, Desain Poster)
            $table->text('description')->nullable(); // Deskripsi singkat jasa
            $table->decimal('price', 10, 2); // Harga jasa (contoh: 100000.00)
            $table->string('image')->nullable(); // Path ke gambar menu/jasa
            $table->boolean('is_active')->default(true); // Status aktif/non-aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
