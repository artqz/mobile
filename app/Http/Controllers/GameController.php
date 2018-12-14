<?php

namespace App\Http\Controllers;

use App\Shop;
use App\ShopList;
use App\Weapon;
use App\User;
use App\Item;
use App\Chat;
use App\Fight;
use App\FightChronology;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use App\Location;
use Carbon\Carbon;

class GameController extends Controller
{
    public function index()
    {
      $user_id = 1;
      //Участвует ли юзер в бою?
      $fight = Fight::where('status', 'battle')->where('user_id', $user_id)->orWhere('enemy_id', $user_id)->first();
      if($fight) {
        //Проверяем количество ходов юзера
        $user_chronologies = FightChronology::where('fight_id', $fight->id)->where('user_id', $user_id )->count();

        if ($fight->user_id == $user_id) {
          $target_type = 'enemy_id';
          $target_id = $fight->enemy_id;
        }
        else {
          $target_type = 'user_id';
          $target_id = $fight->user_id;
        }
        $user = User::where('id', $user_id)->first();
        $target = User::where('id', $target_id)->first();
        //Проверяем делал ли ход враг
        $target_chronologies = FightChronology::where('fight_id', $fight->id)->where('user_id', $target_id )->count();

        $random = random_int(1, 2);
        if($random == 2) {
          $crit = 2;
        }
        else $crit = 1;
        $damage = $user->strength * 11 * $crit;

        if($target->hp_current - $damage <= 0)
        {
            $target->hp_current = 0;
            if($target->save())
            {
              $user->in_battle = false;
              $user->increment('count_wins', 1);
              $user->save();
              $target->in_battle = false;
              $target->increment('count_loses', 1);
              $target->save();
              $fight->status = 'completed';
              $fight->save();

              $chronology = new FightChronology;
              $chronology->round = $user_chronologies + 1;
              $chronology->fight_id = $fight->id;
              $chronology->user_id = $user_id;
              $chronology->target_id = $target_id;
              $chronology->damage = $damage;
              $chronology->text = 'Убил ...';
              $chronology->save();
            }
        }
        else {
            $target->decrement('hp_current', $damage);
            $target->save();

            $chronology = new FightChronology;
            $chronology->round = $user_chronologies + 1;
            $chronology->fight_id = $fight->id;
            $chronology->user_id = $user_id;
            $chronology->target_id = $target_id;
            $chronology->damage = $damage;
            $chronology->text = 'Ударил ....';
            $chronology->save();
        }
      }
    }
}
