<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('inventory_size')->default(12);
            $table->integer('level')->default(1);
            $table->integer('gold')->default(2);
            //Stats
            $table->integer('strength')->default(1);
            $table->integer('dexterity')->default(1);
            $table->integer('constitution')->default(1);
            $table->integer('hp_max')->default(60);
            $table->integer('hp_current')->default(60);
            $table->integer('hp_regen')->default(1);
            //
            $table->string('avatar')->default('default.png');
            $table->integer('sex')->default(0);
            $table->integer('location_id')->references('id')->on('locations')->default(1);
            $table->integer('count_wins')->default(0);
            $table->integer('count_loses')->default(0);
            $table->integer('user_ref_id')->references('id')->on('users')->default(0);
            $table->boolean('in_battle')->default(false);
            $table->dateTime('active_at')->default(Now());
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
