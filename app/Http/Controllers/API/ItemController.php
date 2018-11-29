<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\User;
use App\Http\Resources\Item as ItemResource;

class ItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
         $user_id = $request->input('user_id');
         $user = User::findOrFail($user_id);
         $user_count_items = $user->items->count();
         $user_gold = $user->items->where('itemable_type', 'etc')->where('itemable_id', 1)->first();
         $item_price_gold = $request->item['price'];

         //Проверка на заполненность
         if($user->inventory_size > $user_count_items) {
           $item = new Item;
           $item->itemable_type = $request->item['itemable_type'];
           $item->itemable_id = $request->item['itemable_id'];
           $item->user_id = $user_id;

           //Проверка на достаточное количество денег
           if($user_gold->count >= $item_price_gold) {
             //Вычитаем цену вещи из кошелька

               $user_gold->decrement('count', $item_price_gold);
               if($user_gold->count <= 0) $user_gold->delete();
               if($item->save()) {
                   return new ItemResource($item);
               }
           }
         }
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
