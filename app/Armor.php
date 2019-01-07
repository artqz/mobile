<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Armor extends Model
{
    protected $fillable = [
        'name', 'name_ru', 'p_def'
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
