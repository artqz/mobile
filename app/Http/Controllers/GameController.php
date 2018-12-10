<?php

namespace App\Http\Controllers;

use App\Shop;
use App\ShopList;
use App\Weapon;
use App\User;
use App\Item;
use App\Chat;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use App\Location;
use Carbon\Carbon;

class GameController extends Controller
{
    public function index()
    {
        // $weapon = new Weapon;
        // $weapon->name = 'Sword';
        // $weapon->name_ru = 'Меч';
        // $weapon->p_attack = '1';
        // $weapon->save();
        // //dd($weapon);
        //     $item = new Item;
        $users = User::whereColumn('hp_max', '>', 'hp_current')->get();
        foreach ($users as $key => $user) {
          $user = User::where('id', $user->id)->first();
          $hp_max = $user->hp_max;
          $hp_current = $user->hp_current;
          $hp_regen = 5;
          if($hp_max - $hp_current < $hp_regen)
          {
            $hp_regen = $user->hp_max - $user->hp_current;
          }
          $user->increment('hp_current', $hp_regen);
          $user->save();
        }
          dd($users);
    }
}
