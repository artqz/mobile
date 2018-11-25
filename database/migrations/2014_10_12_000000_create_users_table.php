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
            $table->integer('inventory_size')->default(10);
            $table->integer('level')->default(1);
            //Stats
            $table->integer('strength')->default(1);
            $table->integer('dexterity')->default(1);
            $table->integer('constitution')->default(1);
            //Slots
            $table->integer('slot_weapon')->nullable();
            $table->integer('slot_sub_weapon')->nullable();
            $table->integer('slot_helmet')->nullable();
            $table->integer('slot_armor')->nullable();
            $table->integer('slot_belt')->nullable();
            $table->integer('slot_pants')->nullable();
            $table->integer('slot_gloves')->nullable();
            $table->integer('slot_shoes')->nullable();
            $table->integer('slot_earring_one')->nullable();
            $table->integer('slot_earring_two')->nullable();
            $table->integer('slot_ring_one')->nullable();
            $table->integer('slot_ring_two')->nullable();
            $table->integer('slot_necklace')->nullable();
            $table->integer('slot_bag')->nullable();
            //
            $table->string('avatar')->default('default.png');
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
