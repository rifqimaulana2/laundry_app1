<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayananSatuanTable extends Migration
{
    public function up()
    {
        Schema::create('layanan_satuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_layanan_id');
            $table->string('nama_layanan');
            $table->timestamps();

            $table->foreign('jenis_layanan_id')->references('id')->on('jenis_layanan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanan_satuan');
    }
}
