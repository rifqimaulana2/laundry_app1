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
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->string('nama');
    $table->string('nama_toko');
    $table->string('alamat');
    $table->string('no_telepon');
    $table->string('kecamatan');
    $table->string('longitude')->nullable();
    $table->string('latitude')->nullable();
    $table->boolean('status_approve')->default(false);
    $table->boolean('langganan_aktif')->default(false);
    $table->date('tanggal_langganan_berakhir')->nullable();
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
