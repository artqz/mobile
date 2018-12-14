<?php

namespace App\Http\Controllers\API;

use App\Fight;
use App\FightChronology;
use App\User;
use App\Http\Resources\Fight as FightResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fights = Fight::where('status', 'open')->get();
        return FightResource::collection($fights);
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
      $exists_fight = Fight::where('user_id', $request->user()->id)->where('status', 'open')->first();
      if(!$exists_fight) {
        //Если нет, то создаем бой
        $fight = new Fight;
        $fight->user_id = $request->user()->id;
        $fight->started_at = Now();
        if($fight->save()) {
            return new FightResource($fight);
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
        //$fight = Fight::where('id', $id)->where('status', 'battle')->first();

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
        $fight = Fight::where('id', $id)->where('status', 'open')->first();
        $fight->enemy_id = $request->user()->id;
        $fight->status = 'battle';
        $user = User::where('id', $fight->user_id)->first();
        $user->in_battle = true;
        $enemy = User::where('id', $fight->enemy_id)->first();
        $enemy->in_battle = true;
        if($fight->save() && $user->save() && $enemy->save()) {
            return new FightResource($fight);
        }
    }

    public function current(Request $request)
    {
      $user_id = $request->user()->id;
      $fight = Fight::where('user_id', $user_id)->orWhere('enemy_id', $user_id)->where('status', 'battle')->first();
      return new FightResource($fight);
    }

    public function attack(Request $request)
    {
      $user_id = $request->user()->id;
      $fight = Fight::where('status', 'battle')->where('user_id', $user_id)->orWhere('enemy_id', $user_id)->first();
      $chronology = FightChronology::where('fight_id', $fight->id)->get();
      
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

      $random = random_int(1, 2);
      if($random == 2) {
        $crit = 2;
      }
      else $crit = 1;
      $damage = $user->strength * 10 * $crit;

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
          }
      }
      else {
          $target->decrement('hp_current', $damage);
          $target->save();
      }

      return new FightResource($fight);
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
