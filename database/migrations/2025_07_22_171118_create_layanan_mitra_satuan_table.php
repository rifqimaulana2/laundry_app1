<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayananMitraSatuanTable extends Migration
{
    public function up()
    {
        Schema::create('layanan_mitra_satuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layanan_satuan_id');
            $table->unsignedBigInteger('mitra_id');
            $table->integer('harga_per_item');
            $table->integer('durasi_hari');
            $table->timestamps();

            $table->foreign('layanan_satuan_id')->references('id')->on('layanan_satuan')->onDelete('cascade');
            $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanan_mitra_satuan');
    }
}
