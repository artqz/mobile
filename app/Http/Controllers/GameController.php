<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use App\Location;

class GameController extends Controller
{
    public function index()
    {
        //Загружаем данные о игроке
        $player = Auth::user();
        //Подгружаем локацию
        $location = Location::where('id', $player->location_id)->first();
        return response()->json($location, 200);
        //return view('game')->with('location', $location);
    }
}
