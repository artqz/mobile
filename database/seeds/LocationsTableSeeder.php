<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::create([
            'name' => 'Giran',
            'name_ru' => 'Жиран',
            'x' => '10',
            'y' => '10',
            'width' => '32',
            'height' => '32',
            'background' => 'http://img.combats.ru/i/images/300x225/dream_central.jpg'
        ]);
        Location::create([
            'location_id' => 1,
            'name' => 'Shop',
            'name_ru' => 'Магазин',
            'model' => '/assets/cities/giran/shop.gif',
            'background' => 'http://img.combats.com/i/images/300x225/vok_12_npc.jpg',
            'x' => '52',
            'y' => '20',
            'width' => '32',
            'height' => '32'
        ]);
        Location::create([
            'location_id' => 1,
            'name' => 'Bank',
            'name_ru' => 'Банк',
            'model' => '/assets/cities/giran/bank.gif',
            'background' => 'http://img.combats.ru/i/images/300x225/dream_middle_bank.jpg',
            'x' => '94',
            'y' => '30',
            'width' => '32',
            'height' => '32'
        ]);
        Location::create([
            'location_id' => 1,
            'name' => 'Arena',
            'name_ru' => 'Арена',
            'model' => '/assets/cities/giran/arena.gif',
            'background' => 'http://img.combats.ru/i/images/300x225/dream/warriors_hall.jpg',
            'x' => '136',
            'y' => '40',
            'width' => '32',
            'height' => '32'
        ]);
    }
}
