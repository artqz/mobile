<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespawnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respawns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('npc_id')->references('id')->on('npcs');
            $table->integer('location_id')->references('id')->on('locations');
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
        Schema::dropIfExists('respawns');
    }
}
