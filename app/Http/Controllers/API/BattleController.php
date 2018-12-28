<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Battle;
use App\Round;
use App\Message;
use App\Http\Resources\Battle as BattleResource;

class BattleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $battles = Battle::where('status', 0)->get();
      return BattleResource::collection($battles);
    }

    public function current(Request $request)
    {
      $user_id = $request->user()->id;

      //Status battle:
      //0 - open;
      //1 - battle;
      //2 - close;

      $battle = Battle::where('status', 1)
        ->where('user_id_1', $user_id)
        ->orWhere('status', 1)
        ->where('user_id_2', $user_id)
        ->first();

      if($battle) {
        if ($battle->user_id_1 == $user_id) $user = $battle->user1;
        else $user = $battle->user2;

        $user_last_round = $battle
          ->rounds
          ->where('round', $battle->round)
          ->where('user_id_1', $user->id);

        if ($user_last_round->count() < 1) {
          return new BattleResource($battle);
        }
        else {
          return null;
        }
      }
      else return null;
    }

    public function attack (Request $request) {
      $user_id = $request->user()->id;

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
        $user_damage = $user->strength * 6 * random_int(1,3);

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
              $target->increment('count_loses', 1);
              $target->save();

              $user->in_battle = false;
              $user->decrement('hp_current', $target_last_round->first()->damage);
              $user->increment('count_wins', 1);
              $user->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $target->id;
              $message->is_system = true;
              $message->text ='Вы нанесли '. $user->name . ' ' . $target_last_round->first()->damage . ' ед. урона.';
              $message->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $target->id;
              $message->is_system = true;
              $message->text = $user->name . ' нанес Вам смертельный удар ' . $user_damage . ' ед. урона.';
              $message->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $user->id;
              $message->is_system = true;
              $message->text = $target->name . ' нанес Вам ' . $target_last_round->first()->damage . ' ед. урона.';
              $message->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $user->id;
              $message->is_system = true;
              $message->text ='Вы нанесли смертельный удар '. $target->name . ' ' . $user_damage . ' ед. урона. Это победа! Вы получаете 0 опыта и 0 золота.';
              $message->save();

              $battle->status = 3;
              return $battle->save();
            }
            elseif ($user->hp_current - $target_last_round->first()->damage <=0) {
              $user->hp_current = 0;
              $user->in_battle = false;
              $user->increment('count_loses', 1);
              $user->save();

              $target->in_battle = false;
              $target->decrement('hp_current', $user_damage);
              $target->increment('count_wins', 1);
              $target->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $target->id;
              $message->is_system = true;
              $message->text ='Вы нанесли '. $user->name . ' ' . $target_last_round->first()->damage . ' ед. урона.';
              $message->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $target->id;
              $message->is_system = true;
              $message->text = $user->name . ' нанес Вам смертельный удар ' . $user_damage . ' ед. урона.';
              $message->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $user->id;
              $message->is_system = true;
              $message->text = $target->name . ' нанес Вам ' . $target_last_round->first()->damage . ' ед. урона.';
              $message->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $user->id;
              $message->is_system = true;
              $message->text ='Вы нанесли смертельный удар '. $target->name . ' ' . $user_damage . ' ед. урона. Это победа! Вы получаете 0 опыта и 0 золота.';
              $message->save();

              $battle->status = 3;
              return $battle->save();
            }
            else {
              $target->decrement('hp_current', $user_damage);
              $target->save();


              $user->decrement('hp_current', $target_last_round->first()->damage);
              $user->save();

              //message damage
              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $target->id;
              $message->is_system = true;
              $message->text ='Вы нанесли '. $user->name . ' ' . $target_last_round->first()->damage . ' ед. урона.';
              $message->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $target->id;
              $message->is_system = true;
              $message->text = $user->name . ' нанес Вам ' . $user_damage . ' ед. урона.';
              $message->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $user->id;
              $message->is_system = true;
              $message->text = $target->name . ' нанес Вам ' . $target_last_round->first()->damage . ' ед. урона.';
              $message->save();

              $message = new Message;
              $message->sender_id = 0;
              $message->receiver_id = $user->id;
              $message->is_system = true;
              $message->text ='Вы нанесли '. $target->name . ' ' . $user_damage . ' ед. урона.';
              $message->save();

              $battle->increment('round', 1);
              return $battle->save();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Проверяем имеются ли у пользователя заявки на бой
      $exists_battle = Battle::where('user_id_1', $request->user()->id)->where('status', 0)->first();
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $battle = Battle::where('id', $id)->where('status', 0)->first();
      $battle->user_id_2 = $request->user()->id;
      $battle->status = 1;
      $user1 = $battle->user1;
      $user1->in_battle = true;
      $user2 = $battle->user2;
      $user2->in_battle = true;
      if($battle->save() && $user1->save() && $user2->save()) {
          return new BattleResource($battle);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}