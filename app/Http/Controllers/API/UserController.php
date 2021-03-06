<?php

namespace App\Http\Controllers\API;

use App\Etc;
use App\Battle;
use App\User;
use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Battle as BattleResource;


class UserController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::FindOrFail($id);
        return new UserResource($user);
    }

    public function self(Request $request)
    {
        $user = User::where('id', $request->user()->id)->first();
        return new UserResource($user);
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
        $user =  User::findOrFail($id);

        if ($request->input('update') == 'location') {
            $user->location_id = $request->input('location_id');
            if($user->save()) {
                return new UserResource($user);
            }
        }
    }
    public function get_gold(Request $request)
    {
        $user_id = $request->user()->id;
        $user = User::where('id', $user_id)->first();
        $gold_item = $user->items->where('itemable_type', 'etc')->where('itemable_id', 1)->first();
        if ($gold_item) {
            $gold_item->increment('count', 100);
            $gold_item->save();
        }
        else {
            $item = new Item;
            $item->user_id = $user_id;
            $item->count = 100;

            Etc::where('id', 1)->first()->items()->save($item);
        }

        return 'ok';
    }
    public function remove_item (Request $request, $id)
    {
      $item = Item::where('id', $id)->where('user_id', $request->user()->id)->where('itemable_type', '!=', 'etc')->first();
        if ($item && $item->slot != null) {
            $item->slot = null;
            $item->save();
        }
        return 'ok';
    }
    public function equip_item(Request $request, $id)
    {
        $item = Item::where('id', $id)->where('user_id', $request->user()->id)->first();
        $user_items = $request->user()->items;

        if ($item->itemable_type == 'armor') {
            if ($item->itemable->type == 1) $slot = 'head';
            elseif ($item->itemable->type == 2) $slot = 'chest';
            elseif ($item->itemable->type == 3) $slot = 'legs';
            elseif ($item->itemable->type == 4) $slot = 'gloves';
            elseif ($item->itemable->type == 5) $slot = 'feet';
            elseif ($item->itemable->type == 6) $slot = 'off_hand';
        }
        elseif ($item->itemable_type == 'jewellery') {
            if ($item->itemable->type == 1) {
                $earring_slot_one = $user_items->where('slot', 'earring_one')->first();
                $earring_slot_two = $user_items->where('slot', 'earring_two')->first();

                if (!isset($earring_slot_one)) $slot = 'earring_one';
                elseif (!isset($earring_slot_two)) $slot = 'earring_two';
                elseif (isset($earring_slot_one) || isset($earring_slot_two)) $slot = 'earring_one';
            }
            elseif ($item->itemable->type == 2) {
                $ring_slot_one = $user_items->where('slot', 'ring_one')->first();
                $ring_slot_two = $user_items->where('slot', 'ring_two')->first();

                if (!isset($ring_slot_one)) $slot = 'ring_one';
                elseif (!isset($ring_slot_two)) $slot = 'ring_two';
                elseif (isset($ring_slot_one) || isset($earring_slot_two)) $slot = 'ring_one';
            }
            elseif ($item->itemable->type == 3) $slot = 'necklace';
        }
        elseif ($item->itemable_type == 'weapon') {
            $slot = 'main_hand';
        }

        $is_item_equip = Item::where('slot', $slot)->where('user_id', $request->user()->id)->first();

        if (isset($is_item_equip)) {
            $is_item_equip->slot = null;
            $is_item_equip->save();
        }

        $item->slot = $slot;
        $item->save();
        return $item;
    }

    public function in_battle(Request $request)
    {
        $user_id = $request->user()->id;
        //Status battle:
        //0 - open;
        //1 - battle;
        //2 - close;
        //type battle:
        //0 - pvp;
        //1 - pve;

        $battle = Battle::where('status', 1)
            ->where('user_id_1', $user_id)
            ->first();
        
        if ($battle) {
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
