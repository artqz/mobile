<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'location_id',
        'name',
        'name_ru',
        'type',
        'x',
        'y',
        'background'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function rooms()
    {
        return $this->hasMany('App\Location');
    }
}
