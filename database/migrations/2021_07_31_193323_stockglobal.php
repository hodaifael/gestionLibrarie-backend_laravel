<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Stockglobal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocksglobals', function (Blueprint $table) {
            $table->id();
            $table->string('codep');
            $table->string('name');
            $table->float('pu');
            $table->float('pht');
            $table->string('type');
            $table->integer('qt');
            $table->string('img');
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
