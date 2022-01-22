<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CmdFourniss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmdFourniss', function (Blueprint $table) {
            $table->id();
            $table->integer('numCmdFourniss');
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
        //
    }
}
