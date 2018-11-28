<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etc extends Model
{
  protected $fillable = [
      'name', 'name_ru', 'icon'
  ];
  
  public function items()
  {
      return $this->morphMany('App\Item', 'itemable');
  }
}
