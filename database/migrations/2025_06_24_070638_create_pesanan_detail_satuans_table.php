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
        Schema::create('pesanan_detail_satuans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
    $table->foreignId('layanan_mitra_satuan_id')->constrained('layanan_mitra_satuans')->onDelete('cascade');
    $table->integer('jumlah_item');
    $table->decimal('harga_per_item', 10, 2);
    $table->decimal('subtotal', 10, 2)->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_detail_satuan');
    }
};
