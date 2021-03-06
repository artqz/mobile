<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeaponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //types
        //Bow - 1
        //Dagger - 2
        //Pole - 3
        //Sword - 4
        //Blunt - 5
        //Fist - 6
        Schema::create('weapons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_ru');
            $table->string('icon')->nullable();
            $table->integer('p_atk')->default(1);
            $table->integer('m_atk')->default(1);
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('weapons');
    }
}
