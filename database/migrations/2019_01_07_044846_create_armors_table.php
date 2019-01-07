<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArmorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //types
        //head- 1
        //chest - 2
        //legs - 3
        //gloves - 4
        //feet - 5
        //shield - 6
        Schema::create('armors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_ru');
            $table->string('icon')->nullable();
            $table->integer('p_def')->default(1);
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
        Schema::dropIfExists('armors');
    }
}
