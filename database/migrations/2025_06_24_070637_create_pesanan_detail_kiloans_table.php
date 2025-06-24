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
       Schema::create('pesanan_detail_kiloans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
    $table->foreignId('layanan_mitra_kiloan_id')->constrained('layanan_mitra_kiloans')->onDelete('cascade');
    $table->decimal('berat_sementara', 8, 2)->nullable();
    $table->decimal('berat_real', 8, 2)->nullable();
    $table->decimal('harga_per_kg', 10, 2);
    $table->decimal('subtotal', 10, 2)->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_detail_kiloan');
    }
};
