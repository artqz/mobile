<?php

use Illuminate\Database\Seeder;
use App\Armor;
use App\ShopList;

class ArmorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $armors = [
            //types
            //head- 1
            //chest - 2
            //legs - 3
            //gloves - 4
            //feet - 5
            //shield - 6
            ['name' => 'Shirt', 'name_ru' => 'Рубаха Бздуна', 'p_def' => 33, 'icon' => '/armors/shirt.png', 'type' => 2],
            ['name' => 'Cap', 'name_ru' => 'Шляпа Бздуна', 'p_def' => 16, 'icon' => '/armors/cap.png', 'type' => 1],
            ['name' => 'Pants', 'name_ru' => 'Штаны Бздуна', 'p_def' => 20, 'icon' => '/armors/pants.png', 'type' => 3],
            ['name' => 'Gloves', 'name_ru' => 'Перчатки Бздуна', 'p_def' => 9, 'icon' => '/armors/gloves.png', 'type' => 4],
            ['name' => 'Boots', 'name_ru' => 'Ботинки Бздуна', 'p_def' => 9, 'icon' => '/armors/boots.png', 'type' => 5],
            ['name' => 'Shield', 'name_ru' => 'Щит Бздуна', 'p_def' => 0, 'icon' => '/armors/shield.png', 'type' => 6]
        ];

        foreach($armors as $armor){
            $shop_list = new ShopList;
            $shop_list->shop_id = 1;

            Armor::create($armor)->shops()->save($shop_list);
        }
    }
}
