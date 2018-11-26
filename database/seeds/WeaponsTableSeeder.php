<?php

use Illuminate\Database\Seeder;
use App\Weapon;
use App\ShopList;

class WeaponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $weapons = [
          ['name' => 'Sword', 'name_ru' => 'Меч', 'p_atk' => 1, 'icon' => '/weapons/sword.png'],
          ['name' => 'Staff', 'name_ru' => 'Посох', 'p_atk' => 2, 'icon' => '/weapons/staff.png'],
          ['name' => 'Bow', 'name_ru' => 'Лук', 'p_atk' => 3, 'icon' => '/weapons/bow.png'],
      ];

      foreach($weapons as $weapon){
        $shop_list = new ShopList;
        $shop_list->shop_id = 1;

        Weapon::create($weapon)->shops()->save($shop_list);
      }
    }
}
