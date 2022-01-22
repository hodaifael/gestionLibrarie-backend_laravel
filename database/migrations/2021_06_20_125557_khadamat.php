<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Khadamat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khadamats', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('typerecharge');
            $table->float('montant');
            $table->string('date');
            $table->string('user');
            $table->string('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('khadamats');
    }
}
