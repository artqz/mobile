<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jewellery extends Model
{
    protected $fillable = [
        'name', 'name_ru', 'm_def'
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
