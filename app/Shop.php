<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
  protected $fillable = [
      'name', 'name_ru', 'location_id'
  ];

  public function items()
  {
      return $this->hasMany('App\ShopList');
  }
}
