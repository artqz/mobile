<?php

use Illuminate\Database\Seeder;
use App\Etc;

class EtcsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $items = [
          ['name' => 'Gold', 'name_ru' => 'Золото', 'icon' => '/etc/gold.png'],
      ];

      foreach($items as $item){
        Etc::create($item);
      }
    }
}
