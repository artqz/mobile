<?php

namespace App\Http\Controllers;

use App\Shop;
use App\ShopList;
use App\Weapon;
use App\User;
use App\Item;
use App\Chat;
use App\Fight;
use App\Battle;
use App\Round;
use App\FightChronology;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use App\Location;
use Carbon\Carbon;
use App\Http\Resources\Shop as ShopResource;

class GameController extends Controller
{
    public function index () {
      $target = User::where('id', 1)->first();
      //target armors
      $head = $target->items->where('slot', 'head')->first();
      if ($head) $head_p_def = $head->p_def;
      else $head_p_def = 0;

      $chest = $target->items->where('slot', 'chest')->first();
      if ($chest) $chest_p_def = $chest->p_def;
      else $chest_p_def = 0;

      $legs = $target->items->where('slot', 'legs')->first();
      if ($legs) $legs_p_def = $legs->p_def;
      else $legs_p_def = 0;

      $gloves = $target->items->where('slot', 'gloves')->first();
      if ($gloves) $gloves_p_def = $gloves->p_def;
      else $gloves_p_def = 0;

      $feet = $target->items->where('slot', 'feet')->first();
      if ($feet) $feet_p_def = $feet->p_def;
      else $feet_p_def = 0;

      $off_hand = $target->items->where('slot', 'off_hand')->first();
      if ($off_hand) $off_hand_p_def = $off_hand->p_def;
      else $off_hand_p_def = 0;

      $target_def = $head_p_def + $chest_p_def + $legs_p_def + $gloves_p_def + $feet_p_def + $off_hand_p_def;
      if ($target_def == 0) $target_def = 1;
      dd($feet);
    }
    public function index_t()
    {
      $user_id = 1;
      //Участвует ли юзер в бою?
      $fight = Fight::where('status', 'battle')->where('user_id', $user_id)->orWhere('status', 'battle')->where('enemy_id', $user_id)->first();
      if($fight) {
        if ($fight->user_id == $user_id) {
          $target_type = 'enemy_id';
          $target_id = $fight->enemy_id;
        }
        else {
          $target_type = 'user_id';
          $target_id = $fight->user_id;
        }
        //Получаем данные о юзере и цели
        $user = User::where('id', $user_id)->first();
        $target = User::where('id', $target_id)->first();
        //Проверяем количество ходов юзера
        $user_chronologies_count = FightChronology::where('fight_id', $fight->id)->where('user_id', $user_id )->count();
        //Проверяем делал ли ход враг
        $target_chronologies = FightChronology::where('fight_id', $fight->id)->where('user_id', $target_id )->count();
        //Проверяем количество ходов за раунд
        $user_round = FightChronology::where('fight_id', $fight->id)->where('round', $fight->round)->where('user_id', $user_id);
        $target_round = FightChronology::where('fight_id', $fight->id)->where('round', $fight->round)->where('user_id', $target_id);

        if ($user_round->count() == $target_round->count()) {
          $target->decrement('hp_current', $user_round->first()->damage);
          $target->save();
          $user->decrement('hp_current', $target_round->first()->damage);
          $user->save();
          $fight->increment('round', 1);
          $fight->save();
          dd('все ок!');
        }
        else {
        }
      }
    }
}
