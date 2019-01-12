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
            ['name' => 'Rabbit', 'name_ru' => 'Кролик', 'p_def' => 70, 'p_atk' => 12, 'hp' => 50],
            ['name' => 'Wolf', 'name_ru' => 'Волк', 'p_def' => 80, 'p_atk' => 22, 'hp' => 70],
            ['name' => 'Orc', 'name_ru' => 'Орк', 'p_def' => 80, 'p_atk' => 22, 'hp' => 100],
        ];

        foreach($npcs as $npc){
            Npc::create($npc);
        }
    }
}
