<?php

use Illuminate\Database\Seeder;
use App\Jewellery;
use App\ShopList;

class JewelleriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jewelleries = [
            //types
            //ear - 1
            //finger - 2
            //neck - 3
            ['name' => 'Ring', 'name_ru' => 'Кольцо Бздуна', 'm_def' => 9, 'icon' => '/jewelleries/ring.png', 'type' => 2],
            ['name' => 'Earing ', 'name_ru' => 'Серьга Бздуна', 'm_def' => 9, 'icon' => '/jewelleries/earing.png', 'type' => 1],
            ['name' => 'Necklace ', 'name_ru' => 'Подвеска Бздуна', 'm_def' => 20, 'icon' => '/jewelleries/necklace.png', 'type' => 3],
        ];

        foreach($jewelleries as $jewellery){
            $shop_list = new ShopList;
            $shop_list->shop_id = 1;

            Jewellery::create($jewellery)->shops()->save($shop_list);
        }
    }
}
