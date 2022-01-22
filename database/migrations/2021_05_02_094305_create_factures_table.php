<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->integer('numFinterne');
            $table->integer('numfacture');
            $table->integer('numfour');
            $table->string('codep');
            $table->string('name');
            $table->float('pu');
            $table->float('pht');
            $table->string('type');
            $table->integer('qt');
            $table->string('img');
            $table->integer('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factures');
    }
}
