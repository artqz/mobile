<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respawn extends Model
{
    public function npc()
    {
        return $this->belongsTo('App\Npc');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
