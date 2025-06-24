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
        Schema::create('layanan_kiloans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket'); // Contoh: Reguler, Ekspres
            $table->unsignedInteger('durasi_hari'); // Hari pengerjaan
            $table->unsignedInteger('harga_per_kg'); // Harga per kilogram
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_kiloans');
    }
};
