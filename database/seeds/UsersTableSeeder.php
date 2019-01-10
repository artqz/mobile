<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Item;
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
      $users = [
          ['name' => 'Убивака', 'email' => 'djoctuk@yandex.ru', 'password' => Hash::make(110789)],
          ['name' => 'Chlens', 'email' => 'test@test.ru', 'password' => Hash::make(110789)],
          ['name' => 'Jesus', 'email' => 'fox.toddtester@gmail.com', 'password' => Hash::make(12345)],
          ['name' => 'Anrew', 'email' => 'hotmottor@gmail.com', 'password' => Hash::make(12345)]
      ];

      foreach($users as $user){
        $bug = new Item;
        $bug->slot = 'bag';
        $bug->itemable_type = 'etc';
        $bug->itemable_id = 2;
        $bug->count = 1;

        User::create($user)->items()->save($bug);
      }
    }
}
