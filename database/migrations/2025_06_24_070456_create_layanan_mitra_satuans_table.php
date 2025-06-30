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
        Schema::create('layanan_mitra_satuans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
    $table->foreignId('layanan_satuan_id')->constrained('layanan_satuans')->onDelete('cascade');
    $table->integer('harga_satuan'); // ← INI HARUS ADA
    $table->timestamps();
});



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_mitra_satuans');
    }
};
