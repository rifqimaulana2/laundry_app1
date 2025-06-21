<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokosTable extends Migration
{
    public function up()
    {
        Schema::create('tokos', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('alamat');
            $table->string('kontak');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tokos');
    }
}