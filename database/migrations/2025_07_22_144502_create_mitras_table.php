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
        Schema::create('mitras', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nama_toko');
        $table->string('kecamatan');
        $table->text('alamat_lengkap');
        $table->string('longitude');
        $table->string('latitude');
        $table->string('foto_toko')->nullable();
        $table->string('no_telepon');
        $table->enum('status_approve', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->string('foto_profile')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
