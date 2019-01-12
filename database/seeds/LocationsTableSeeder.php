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
            'type' => 'town',
            'x' => '10',
            'y' => '10',
            'width' => '32',
            'height' => '32',
            'background' => '/giran/giran_bg.jpg'
        ]);
        Location::create([
            'location_id' => 1,
            'name' => 'Shop',
            'name_ru' => 'Магазин',
            'type' => 'shop',
            'model' => '/giran/shop.png',
            'background' => '/giran/giran_bg.jpg',
            'x' => '52',
            'y' => '100',
            'width' => '32',
            'height' => '32'
        ]);
        Location::create([
            'location_id' => 1,
            'name' => 'Bank',
            'name_ru' => 'Банк',
            'type' => 'bank',
            'model' => '/giran/bank.png',
            'background' => '/giran/giran_bg.jpg',
            'x' => '250',
            'y' => '150',
            'width' => '32',
            'height' => '32'
        ]);
        Location::create([
            'location_id' => 1,
            'name' => 'Arena',
            'name_ru' => 'Арена',
            'type' => 'arena',
            'model' => '/giran/arena.png',
            'background' => '/giran/giran_bg.jpg',
            'x' => '136',
            'y' => '40',
            'width' => '32',
            'height' => '32'
        ]);
        Location::create([
            'location_id' => 1,
            'name' => 'Fields',
            'name_ru' => 'Пригородные поля',
            'type' => 'arena',
            'model' => '/giran/tower.png',
            'background' => '/giran/giran_bg.jpg',
            'x' => '0',
            'y' => '0',
            'width' => '32',
            'height' => '32'
        ]);
    }
}
