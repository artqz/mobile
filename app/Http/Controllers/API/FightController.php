<?php

namespace App\Http\Controllers\API;

use App\Fight;
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
