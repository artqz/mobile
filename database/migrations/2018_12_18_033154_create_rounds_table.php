<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('round')->nullable();
          $table->integer('battle_id')->references('id')->on('battles');
          $table->integer('user_id_1')->references('id')->on('users');
          $table->integer('user_id_2')->references('id')->on('users');
          $table->integer('damage')->nullable();
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
        Schema::dropIfExists('rounds');
    }
}
