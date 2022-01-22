<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommandeNiveau extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandeNiveaus', function (Blueprint $table) {
            $table->id();
            $table->integer('numNiveau');
            $table->string('codep');
            $table->string('name');
            $table->float('pu');
            $table->float('totalligne');
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
        //
    }
}
