<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGejala extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_gejala', function (Blueprint $table) {
            $table->id('id');
            $table->float('umur');
            $table->float('jenis_kelamin');
            $table->float('kehamilan');
            $table->float('TSH');
            $table->float('T3');
            $table->float('TT4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_gejala');
    }
}
