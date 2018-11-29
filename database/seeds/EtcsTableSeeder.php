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
      ];
      $item = new Item;
      $item->user_id = 1;
      $item->count = 5;
      foreach($etcItems as $etcItem){
        Etc::create($etcItem)->items()->save($item);
      }
    }
}
