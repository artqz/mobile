<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'level', 'sex', 'town_id', 'count_wins', 'count_loses', 'user_ref_id',
        'slot_weapon',
        'slot_sub_weapon',
        'slot_helmet',
        'slot_armor',
        'slot_belt',
        'slot_pants',
        'slot_gloves',
        'slot_shoes',
        'slot_earring_one',
        'slot_earring_two',
        'slot_ring_one',
        'slot_ring_two',
        'slot_necklace',
        'slot_bag',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
