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
    Schema::table('walkin_customer', function (Blueprint $table) {
        $table->foreignId('mitras_id')->after('alamat')->constrained('mitras')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('walkin_customer', function (Blueprint $table) {
        $table->dropForeign(['mitras_id']);
        $table->dropColumn('mitras_id');
    });
    }
};
