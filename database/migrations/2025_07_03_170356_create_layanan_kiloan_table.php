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
        Schema::create('layanan_kiloan', function (Blueprint $table) {
    $table->id();
    $table->string('nama_paket'); // Reguler, Ekspres, dll
    $table->unsignedInteger('durasi_hari'); // estimasi durasi
    $table->unsignedInteger(column: 'harga_per_kg');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_kiloan');
    }
};
