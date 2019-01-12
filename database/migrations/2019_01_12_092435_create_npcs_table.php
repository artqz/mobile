<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNpcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('npcs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_ru');
            //Stats
            $table->integer('p_atk')->default(1);
            $table->integer('p_def')->default(1);
            $table->integer('m_atk')->default(1);
            $table->integer('m_def')->default(1);
            $table->integer('hp')->default(60);
            //
            $table->string('avatar')->default('/npc/default.png');
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
        Schema::dropIfExists('npcs');
    }
}
