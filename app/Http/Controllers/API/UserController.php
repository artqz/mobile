<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;


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
    public function equip_item(Request $request)
    {
      $select_item = $request->item;

      if ($select_item['itemable_type'] == 'weapon') {
        $slot = 'main_hand';
        $remove_item = Item::where('slot', $slot)->first();

        if (isset($remove_item)) {
          $remove_item->slot = null;
          $remove_item->save();
        }
        $eqip_item = Item::findOrFail($select_item['id']);
        $eqip_item->slot = $slot;
        $eqip_item->save();
        return $eqip_item;
      }
      else {
        return 'govho';
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
