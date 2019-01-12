<?php

use Illuminate\Database\Seeder;
use App\Respawn;

class RespawnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $respawns = [
            ['npc_id' => 1, 'location_id' => 4],
            ['npc_id' => 2, 'location_id' => 4],
        ];

        foreach($respawns as $respawn){
            Respawn::create($respawn);
        }
    }
}
