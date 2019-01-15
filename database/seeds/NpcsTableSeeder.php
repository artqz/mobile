<?php

use Illuminate\Database\Seeder;
use App\Npc;

class NpcsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $npcs = [
            ['name' => 'Rabbit', 'name_ru' => 'Кролик', 'level' => 1, 'p_def' => 70, 'p_atk' => 12, 'hp_max' => 50, 'hp_current' => 50],
            ['name' => 'Wolf', 'name_ru' => 'Волк', 'level' => 2, 'p_def' => 80, 'p_atk' => 22, 'hp_max' => 70, 'hp_current' => 70],
            ['name' => 'Orc', 'name_ru' => 'Орк', 'level' => 3, 'p_def' => 80, 'p_atk' => 22, 'hp_max' => 100, 'hp_current' => 100],
        ];

        foreach($npcs as $npc){
            Npc::create($npc);
        }
    }
}
