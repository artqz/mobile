<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Battle;
use App\Round;
use App\Message;
use App\Http\Resources\Battle as BattleResource;

class PveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function current(Request $request)
    {
        $user_id = $request->user()->id;

        //Status battle:
        //0 - open;
        //1 - battle;
        //2 - close;

        $battle = Battle::where('status', 1)
            ->where('type', 1)
            ->where('user_id_1', $user_id)
            ->first();

        if($battle) {
            $user = $battle->user1;

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

    public function attack (Request $request)
    {
        $user_id = $request->user()->id;

        //Status battle:
        //0 - open;
        //1 - battle;
        //2 - close;

        $battle = Battle::where('status', 1)
            ->where('type', 1)
            ->where('user_id_1', $user_id)
            ->first();
        return new BattleResource($battle);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user_id = $request->user()->id;
      $npc_id = $request->input('npc_id');
      // Проверяем имеются ли у пользователя заявки на бой
      $exists_battle = Battle::where('user_id_1', $user_id)->where('status', 0)->first();
      if(!$exists_battle) {
        //Если нет, то создаем бой
        $battle = new Battle;
        $battle->user_id_1 = $user_id;
        $battle->npc_id = $npc_id;
        $battle->started_at = Now();
        $battle->type = 1;
        $battle->status = 1;

        if($battle->save()) {
            $user = $battle->user1;
            $user->in_battle = 1;
            $user->save();
            
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
        //
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
