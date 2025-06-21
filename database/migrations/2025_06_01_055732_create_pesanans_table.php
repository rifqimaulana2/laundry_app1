<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('toko_id');
            $table->string('nama');
            $table->string('telepon');
            $table->text('alamat');
            $table->enum('jenis_layanan', ['satuan', 'kiloan']);
            $table->text('detail_layanan')->nullable();
            $table->enum('metode_pembayaran', ['transfer', 'cod']);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
