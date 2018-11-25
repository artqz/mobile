<?php

namespace App\Http\Controllers;

use App\Item;
use App\Weapon;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use App\Location;

class GameController extends Controller
{
    public function index()
    {
//        $weapon = new Weapon;
//        $weapon->name = 'Sword';
//        $weapon->name_ru = 'Меч';
//        $weapon->p_attack = '1';
//        $weapon->save();
//        dd($weapon);
            $item = new Item;
          $weapon = Weapon::find(1);
        $itemable = $item->itemable($weapon);
        dd($itemable);
    }
}
