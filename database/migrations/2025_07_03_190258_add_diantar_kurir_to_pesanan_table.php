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
    Schema::table('pesanan', function (Blueprint $table) {
        $table->boolean('diantar_kurir')->default(false)->after('dijemput_kurir');
    });
}

public function down(): void
{
    Schema::table('pesanan', function (Blueprint $table) {
        $table->dropColumn('diantar_kurir');
    });
}

};
