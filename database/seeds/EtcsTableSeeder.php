<?php

use Illuminate\Database\Seeder;
use App\Etc;
use App\Item;

class EtcsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $etcItems = [
        //types
        //other- 1
        //potion - 2
        //bag - 3
          ['name' => 'Gold', 'name_ru' => 'Золото', 'type' => 1, 'icon' => '/etc/gold.png'],
          ['name' => 'Small Bag', 'name_ru' => 'Маленькая сумка', 'type' => 3, 'value' => 12, 'icon' => '/etc/bag_small.png'],
          ['name' => 'Medium Bag', 'name_ru' => 'Средняя сумка', 'type' => 3, 'value' => 24, 'icon' => '/etc/bag_medium.png'],
          ['name' => 'Big Bag', 'name_ru' => 'Большая сумка', 'type' => 3, 'value' => 48, 'icon' => '/etc/bag_big.png'],
          ['name' => 'Heal Potion', 'name_ru' => 'Зелье Здоровья', 'type' => 3, 'value' => 50, 'icon' => '/etc/hp_potion_small.png']
      ];

      foreach($etcItems as $etcItem){
        Etc::create($etcItem);
      }
    }
}
