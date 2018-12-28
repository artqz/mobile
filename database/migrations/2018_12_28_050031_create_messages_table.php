<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
          $table->increments('id');
          $table->string('text');
          $table->integer('sender_id')->references('id')->on('users')->default(false);
          $table->integer('receiver_id')->references('id')->on('users')->default(false);
          $table->boolean('is_system')->default(false); //type 0 - user message, 2 - private message, 3 - battle message
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
        Schema::dropIfExists('messages');
    }
}
