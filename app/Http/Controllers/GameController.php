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
        $chat = Chat::find(1);
        dd($chat->user);
    }
}
