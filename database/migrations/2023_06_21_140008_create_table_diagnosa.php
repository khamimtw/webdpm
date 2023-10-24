<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDiagnosa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_diagnosa', function (Blueprint $table) {
            $table->id('id_diagnosa');
            $table->decimal('hasil_diagnosa',15,14);
            $table->string('presentase');
            $table->unsignedBigInteger('id_gejala');
            $table->unsignedBigInteger('id_level');
            $table->timestamps();

            $table->foreign('id_gejala')->references('id')->on('table_gejala');
            $table->foreign('id_level')->references('id')->on('table_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_diagnosa');
    }
}
