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
          ['name' => 'Gold', 'name_ru' => 'Золото', 'icon' => '/etc/gold.png'],
          ['name' => 'Heal Potion', 'name_ru' => 'Зелье Здоровья', 'icon' => '/etc/hp_potion_small.png']
      ];

      foreach($etcItems as $etcItem){
        Etc::create($etcItem);
      }
    }
}
