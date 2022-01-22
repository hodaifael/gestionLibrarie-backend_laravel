<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Retourbenef extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retourbenefs', function (Blueprint $table) {
            $table->id();
            $table->integer('num');
            $table->integer('numcommande');
            $table->float('point');
            $table->float('montant');
            $table->float('benefice');
            $table->float('newpoint');
            $table->float('newmontant');
            $table->float('newbenefice');
            $table->float('return');
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
        //
    }
}
