<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopList extends Model
{
  protected $fillable = [
      'price',
  ];

  public function itemable()
  {
      return $this->morphTo();
  }
}
