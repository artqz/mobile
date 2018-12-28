<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = [
      'text', 'sender_id', 'receiver_id', 'is_system'
  ];
  public function sender()
  {
    return $this->belongsTo('App\User', 'sender_id');
  }

  public function receiver()
  {
    return $this->belongsTo('App\User', 'receiver_id');
  }
}
