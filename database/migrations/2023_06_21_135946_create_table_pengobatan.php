<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePengobatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_pengobatan', function (Blueprint $table) {
            $table->id('id');
            $table->string('pengobatan');
            $table->unsignedBigInteger('level_penyakit');
            $table->timestamps();

            $table->foreign('level_penyakit')->references('id')->on('table_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_pengobatan');
    }
}
