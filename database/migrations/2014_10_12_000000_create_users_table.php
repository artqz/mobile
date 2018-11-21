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
            $table->string('avatar')->default('default.jpg');
            $table->integer('level')->default(0);
            $table->integer('sex')->default(0);
            $table->integer('location_id')->references('id')->on('locations')->default(1);
            $table->integer('count_wins')->default(0);
            $table->integer('count_loses')->default(0);
            $table->integer('user_ref_id')->references('id')->on('users')->default(0);
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
