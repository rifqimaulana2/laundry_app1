<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalkinCustomersTable extends Migration
{
    public function up(): void
    {
        Schema::create('walkin_customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_tlp');
            $table->text('alamat');
            $table->unsignedBigInteger('mitra_id');
            $table->timestamps();

            $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('walkin_customers');
    }
}
