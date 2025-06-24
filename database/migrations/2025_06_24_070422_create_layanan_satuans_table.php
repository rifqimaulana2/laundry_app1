<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan_satuans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan'); // Contoh: Sepatu, Jaket, dll
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_satuans');
    }
};
