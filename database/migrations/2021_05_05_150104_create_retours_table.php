<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retours', function (Blueprint $table) {
            $table->id();
            $table->string('numfacture');
            $table->string('codep');
            $table->string('name');
            $table->float('pu');
            $table->float('totalligne');
            $table->integer('qt');
            $table->string('img');
            $table->integer('user');
            $table->string('date');
            $table->string('heure');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retours');
    }
}
