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
    Schema::table('layanan_kiloan', function (Blueprint $table) {
        $table->dropColumn('harga_per_kg');
    });
}

public function down(): void
{
    Schema::table('layanan_kiloan', function (Blueprint $table) {
        $table->unsignedInteger('harga_per_kg')->nullable(); // optional rollback
    });
}

};
