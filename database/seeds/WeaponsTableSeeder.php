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
          //types
            //Bow - 1
            //Dagger - 2
            //Pole - 3
            //Sword - 4
            //Blunt - 5
            //Fist - 6
          ['name' => 'Sword', 'name_ru' => 'Меч Бздуна', 'p_atk' => 6, 'm_atk' => 5, 'icon' => '/weapons/sword.png', 'type' => 4],
          ['name' => 'Staff', 'name_ru' => 'Посох Бздуна', 'p_atk' => 5, 'm_atk' => 7, 'icon' => '/weapons/staff.png', 'type' => 5],
          ['name' => 'Bow', 'name_ru' => 'Лук Бздуна', 'p_atk' => 16, 'm_atk' => 6, 'icon' => '/weapons/bow.png', 'type' => 1],
          ['name' => 'Dagger', 'name_ru' => 'Нож Бздуна', 'p_atk' => 5, 'm_atk' => 5, 'icon' => '/weapons/bow.png', 'type' => 1],
      ];

      foreach($weapons as $weapon){
        $shop_list = new ShopList;
        $shop_list->shop_id = 1;

        Weapon::create($weapon)->shops()->save($shop_list);
      }
    }
}
