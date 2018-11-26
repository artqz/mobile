<?php

use Illuminate\Database\Seeder;
use App\Shop;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Shop::create([
          'name' => 'Shop Weapon',
          'name_ru' => 'Оружейный магазин',
          'location_id' => 2
      ]);
    }
}
