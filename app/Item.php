<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'itemable_type', 'itemable_id', 'user_id', 'is_used'
    ];
    public function gold()
    {
      return $this;
    }
    public function itemable()
    {
        return $this->morphTo();
    }
}
