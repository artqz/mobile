<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function itemable()
    {
        return $this->morphTo();
    }
}
