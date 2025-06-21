<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: membuat tabel 'layanans'
     */
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('toko_id'); // relasi ke tabel 'tokos'
            $table->string('nama_layanan');
            $table->integer('harga');
            $table->timestamps();

            // Definisikan foreign key: toko_id mengacu ke id di tabel tokos
            $table->foreign('toko_id')->references('id')->on('tokos')->onDelete('cascade');
        });
    }

    /**
     * Rollback migrasi
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
