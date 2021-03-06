<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocationsTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(WeaponsTableSeeder::class);
        $this->call(ArmorsTableSeeder::class);
        $this->call(JewelleriesTableSeeder::class);
        $this->call(EtcsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(NpcsTableSeeder::class);
        $this->call(RespawnsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
    }
}
