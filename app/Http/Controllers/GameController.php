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

class GameController extends Controller
{
    public function index () {
      $user_id = 1;

      //Status battle:
      //0 - open;
      //1 - battle;
      //2 - close;

      $battle = Battle::where('status', 1)
        ->where('user_id_1', $user_id)
        ->orWhere('status', 1)
        ->where('user_id_2', $user_id)
        ->first();

      if ($battle->user_id_1 == $user_id) {
        $user = $battle->user1;
        $target = $battle->user2;
      }
      else {
        $user = $battle->user2;
        $target = $battle->user1;
      }

      $user_last_round = $battle
        ->rounds
        ->where('round', $battle->round)
        ->where('user_id_1', $user->id);
        
      $target_last_round = $battle
        ->rounds
        ->where('round', $battle->round)
        ->where('user_id_1', $target->id);

      if ($user_last_round->count() < 1) {
        $user_damage = $user->strength * random_int(1,3);

        $round = new Round;
        $round->user_id_1 = $user->id;
        $round->user_id_2 = $target->id;
        $round->battle_id = $battle->id;
        $round->round = $battle->round;
        $round->damage = $user_damage;
        $round->text = $user->name . ' нанес ' . $target->name . ' ' . $user_damage . ' ед. урона.';

        if ($round->save()) {
          if ($target_last_round->count() == 1) {
            if ($target->hp_current - $user_damage <= 0) {
              $target->hp_current = 0;
              $target->in_battle = false;
              $target->save();

              $battle->status = 3;
              $battle->save();
            }
            elseif ($user->hp_current - $target_last_round->first()->damage <=0) {
              $user->hp_current = 0;
              $user->in_battle = false;
              $user->save();

              $battle->status = 3;
              $battle->save();
            }
            else {
              $target->decrement('hp_current', $user_damage);
              $target->save();

              $user->decrement('hp_current', $target_last_round->first()->damage);
              $user->save();

              $battle->increment('round', 1);
              $battle->save();
            }
          }
          else {
            return 'jdem hod protivnika!';
          }
        }
      }
      elseif ($user_last_round == $target_last_round) {
        dd('raschet');
      }
      elseif ($user_last_round > $target_last_round) {
        return 'jdem hod protivnika!';
      }
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
