<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFightChronologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fight_chronologies', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('round')->nullable();
          $table->integer('fight_id')->references('id')->on('fights');
          $table->integer('user_id')->references('id')->on('users');
          $table->integer('target_id')->references('id')->on('users');
          $table->integer('damage')->nullable();
          $table->string('text')->nullable();
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
        Schema::dropIfExists('fight_chronologies');
    }
}
