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
        Schema::create('notifikasi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pesanan_id')->nullable()->constrained('pesanans')->onDelete('set null');
    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
    $table->string('judul');
    $table->text('aktivitas'); // contoh: “DP dibayar”, “Pesanan dikonfirmasi”
    $table->boolean('status_baca')->default(false);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
