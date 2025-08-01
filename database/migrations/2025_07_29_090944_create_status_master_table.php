<?php

// database/migrations/xxxx_xx_xx_create_status_master_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusMasterTable extends Migration
{
    public function up()
    {
        Schema::create('status_master', function (Blueprint $table) {
            $table->id();
            $table->string('nama_status')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('status_master');
    }
};

