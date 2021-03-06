<?php

namespace App\Http\Controllers;

use App\Etc;
use App\Shop;
use App\ShopList;
use App\Weapon;
use App\User;
use App\Item;
use App\Chat;
use App\Respawn;
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
      $user_id = 1;
      $id = 4;
      $respawn = Respawn::where('location_id', $id)->get();
      return $respawn;

      // Проверяем имеются ли у пользователя заявки на бой
      $exists_battle = Battle::where('user_id_1', $user_id)->where('status', 0)->first();
      if(!$exists_battle) {
        //Если нет, то создаем бой
        $battle = new Battle;
        $battle->user_id_1 = $request->user()->id;
        $battle->started_at = Now();
        if($battle->save()) {
          return new BattleResource($battle);
        }
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
