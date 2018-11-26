<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    protected $fillable = [
        'name', 'name_ru', 'p_attack'
    ];
    public function items()
    {
        return $this->morphMany('App\Item', 'itemable');
    }
    public function shops()
    {
        return $this->morphMany('App\ShopList', 'itemable');
    }
}
