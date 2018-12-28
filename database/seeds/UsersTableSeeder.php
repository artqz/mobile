<?php

use Illuminate\Database\Seeder;
use App\User;
use \Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name' => 'Убивака', 'email' => 'djoctuk@yandex.ru', 'password' => Hash::make(110789)]);
        User::create(['name' => 'Chlens', 'email' => 'test@test.ru', 'password' => Hash::make(110789)]);
        User::create(['name' => 'Jesus', 'email' => 'fox.toddtester@gmail.com', 'password' => Hash::make(12345)]);
        User::create(['name' => 'Anrew', 'email' => 'hotmottor@gmail.com', 'password' => Hash::make(12345)]);
    }
}
