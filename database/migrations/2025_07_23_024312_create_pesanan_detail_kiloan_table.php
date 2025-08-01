<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananDetailKiloanTable extends Migration
{
    public function up()
    {
        Schema::create('pesanan_detail_kiloan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->foreignId('layanan_mitra_kiloan_id')->constrained('layanan_mitra_kiloan')->onDelete('cascade');
            $table->float('berat_sementara')->nullable();
            $table->float('berat_final')->nullable();
            $table->integer('harga_per_kg');
            $table->integer('subtotal')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan_detail_kiloan');
    }
}
