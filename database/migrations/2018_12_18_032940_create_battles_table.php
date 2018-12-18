<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battles', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id_1')->references('id')->on('users');
          $table->integer('user_id_2')->references('id')->on('users')->nullable();
          $table->integer('status')->default(0);
          $table->integer('round')->nullable();
          $table->dateTime('started_at')->nullable();
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
        Schema::dropIfExists('battles');
    }
}
