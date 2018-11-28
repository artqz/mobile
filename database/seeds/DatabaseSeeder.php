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
        $this->call(UsersTableSeeder::class);
        $this->call(WeaponsTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(EtcsTableSeeder::class);
    }
}
