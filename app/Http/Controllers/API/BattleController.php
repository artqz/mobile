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

    public function pve_current (Request $request)
    {
      //Status battle:
      //0 - open;
      //1 - battle;
      //2 - close;
      //type battle:
      //0 - pvp;
      //1 - pve;

      $battle = Battle::where('status', 1)
        ->where('user_id_1', $user_id)
        ->where('type', 1)
        ->first();

      if ($battle) {
        return new BattleResource($battle);
      }
    }

    public function current(Request $request)
    {
      $user_id = $request->user()->id;

      //Status battle:
      //0 - open;
      //1 - battle;
      //2 - close;

      $battle = Battle::where('status', 1)
        ->where('type', 0)
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
        ->where('type', 0)
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
        //target armors
        $head = $target->items->where('slot', 'head')->first();
        if ($head) $head_p_def = $head->itemable->p_def;
        else $head_p_def = 0;

        $chest = $target->items->where('slot', 'chest')->first();
        if ($chest) $chest_p_def = $chest->itemable->p_def;
        else $chest_p_def = 0;

        $legs = $target->items->where('slot', 'legs')->first();
        if ($legs) $legs_p_def = $legs->itemable->p_def;
        else $legs_p_def = 0;

        $gloves = $target->items->where('slot', 'gloves')->first();
        if ($gloves) $gloves_p_def = $gloves->itemable->p_def;
        else $gloves_p_def = 0;

        $feet = $target->items->where('slot', 'feet')->first();
        if ($feet) $feet_p_def = $feet->itemable->p_def;
        else $feet_p_def = 0;

        $off_hand = $target->items->where('slot', 'off_hand')->first();
        if ($off_hand) $off_hand_p_def = $off_hand->itemable->p_def;
        else $off_hand_p_def = 0;

        $target_armor_def = $head_p_def + $chest_p_def + $legs_p_def + $gloves_p_def + $feet_p_def + $off_hand_p_def;
        if ($target_armor_def == 0) $target_armor_def = 1;

        $target_con_mod = 1+(($target->constitution*10)/100);
        $target_level_mod = 1+(($target->level*10)/100);

        $target_def = $target_armor_def * $target_con_mod * $target_level_mod;

        //weapon
        $weapon = $user->items
          ->where('slot', 'main_hand')
          ->first();

        if ($weapon) {
          $weapon_p_atk = $weapon->itemable->p_atk;

          //Определяем вероятность крита от типа оружия
          $weapon_type = $weapon->itemable->type;
          if ($weapon_type == 1) $weapon_cc = 120;
          elseif ($weapon_type == 2) $weapon_cc = 120;
          elseif ($weapon_type == 3) $weapon_cc = 40;
          elseif ($weapon_type == 4) $weapon_cc = 60;
          elseif ($weapon_type == 5) $weapon_cc = 50;
          elseif ($weapon_type == 6) $weapon_cc = 70;
        }
        else {
          $weapon_p_atk = 1;
          $weapon_cc = 30;
        }

        //Определяем шанс крита
        $critical_chance = $weapon_cc / 1000 * 100;

        //Рандомими критический удар
        function critical_hit($critical_chance)
        {
          if (mt_rand(1, 99) <= $critical_chance) {
            $critical_damage = 2;
          }
          else $critical_damage = 1;
          return $critical_damage;
        }

        //Получаем множитель критического урона
        $critical_damage = critical_hit($critical_chance);

        //Считаем модификатор уровня
        $lvl_mod = (($user->level + 89 + 4) * $user->level) / 100;

        //Считаем физическую атаку игрока
        $user_p_atk = round(70 * ($critical_damage * $weapon_p_atk * $lvl_mod * $user->strength)/$target_def);
        $user_damage = $user_p_atk;

        //Записываем результат раунда в таблицу
        $round = new Round;
        $round->user_id_1 = $user->id;
        $round->user_id_2 = $target->id;
        $round->battle_id = $battle->id;
        $round->round = $battle->round;
        $round->damage = $user_damage;

        if ($round->save()) {
          if ($target_last_round->count() == 1) {
            if ($target->hp_current - $user_damage <= 0 && $user->hp_current - $target_last_round->first()->damage <=0  ) {
              $target->hp_current = 0;
              $target->in_battle = false;
              $target->increment('count_deadheat', 1);
              $target->save();

              $user->hp_current = 0;
              $user->in_battle = false;
              $user->increment('count_deadheat', 1);
              $user->save();

              //Отправляем системные сообщения
              $messages = [
                  [
                    'sender_id' => '0',
                    'receiver_id' => $target->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] ' . $user->name . ' нанес Вам смертельный удар ' . $user_damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $target->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] Вы нанесли смертельный удар '. $user->name . ' ' . $target_last_round->first()->damage . ' ед. урона. Это ничья! Вы получаете 0 опыта и 0 золота.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $user->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] ' .$target->name . ' нанес Вам смертельный удар ' . $target_last_round->first()->damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $user->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] Вы нанесли смертельный удар '. $target->name . ' ' . $user_damage . ' ед. урона. Это ничья! Вы получаете 0 опыта и 0 золота.'
                  ]
              ];

              foreach($messages as $message){
                Message::create($message);
              }

              $battle->status = 3;
              $battle->save();

              return response()->json(['success' => $battle]);
            }
            elseif ($target->hp_current - $user_damage <= 0) {
              $target->hp_current = 0;
              $target->in_battle = false;
              $target->increment('count_loses', 1);
              $target->save();

              $user->in_battle = false;
              $user->decrement('hp_current', $target_last_round->first()->damage);
              $user->increment('count_wins', 1);
              $user->save();

              //Отправляем системные сообщения
              $messages = [
                  [
                    'sender_id' => '0',
                    'receiver_id' => $target->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] Вы нанесли '. $user->name . ' ' . $target_last_round->first()->damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $target->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] ' . $user->name . ' нанес Вам смертельный удар ' . $user_damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $user->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] ' .$target->name . ' нанес Вам ' . $target_last_round->first()->damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $user->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] Вы нанесли смертельный удар '. $target->name . ' ' . $user_damage . ' ед. урона. Это победа! Вы получаете 0 опыта и 0 золота.'
                  ]
              ];

              foreach($messages as $message){
                Message::create($message);
              }

              $battle->status = 3;
              $battle->save();

              return response()->json(['success' => $battle]);
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

              //Отправляем системные сообщения
              $messages = [
                  [
                    'sender_id' => '0',
                    'receiver_id' => $user->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] Вы нанесли '. $target->name . ' ' . $user_damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $user->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] ' . $target->name . ' нанес Вам смертельный удар ' . $target_last_round->first()->damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $target->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] ' .$user->name . ' нанес Вам ' . $user_damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $target->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] Вы нанесли смертельный удар '. $user->name . ' ' . $target_last_round->first()->damage . ' ед. урона. Это победа! Вы получаете 0 опыта и 0 золота.'
                  ]
              ];

              foreach($messages as $message){
                Message::create($message);
              }

              $battle->status = 3;
              $battle->save();

              return response()->json(['success' => $battle]);
            }
            else {
              $target->decrement('hp_current', $user_damage);
              $target->save();


              $user->decrement('hp_current', $target_last_round->first()->damage);
              $user->save();

              //Отправляем системные сообщения
              $messages = [
                  [
                    'sender_id' => '0',
                    'receiver_id' => $user->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] Вы нанесли '. $target->name . ' ' . $user_damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $user->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] ' . $target->name . ' нанес Вам ' . $target_last_round->first()->damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $target->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] Вы нанесли '. $user->name . ' ' . $target_last_round->first()->damage . ' ед. урона.'
                  ],
                  [
                    'sender_id' => '0',
                    'receiver_id' => $target->id,
                    'is_system' => true,
                    'text' => '[Раунд: '.$round->round.'] ' .$user->name . ' нанес Вам ' . $user_damage . ' ед. урона.'
                  ]
              ];

              foreach($messages as $message){
                Message::create($message);
              }

              $battle->increment('round', 1);
              $battle->save();

              return response()->json(['success' => $battle]);
            }
          }
          else {
            return 'jdem hod protivnika!';
          }
        }
      }
      elseif ($user_last_round == $target_last_round) {
        return 'og';
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
        $battle->type = 0;
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
