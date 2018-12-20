<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('chat/users_online', 'API\ChatController@users_online');
    Route::apiResources(['chat' => 'API\ChatController']);
    Route::get('fights/current', 'API\FightController@current');
    Route::post('fights/attack', 'API\FightController@attack');
    Route::apiResources(['fights' => 'API\FightController']);
    Route::get('battles/current', 'API\BattleController@current');
    Route::post('battles/attack', 'API\BattleController@attack');
    Route::apiResources(['battles' => 'API\BattleController']);
});
Route::apiResources(['users' => 'API\UserController']);
  Route::post('users/equip_item', 'API\UserController@equip_item');
Route::apiResources(['locations' => 'API\LocationController']);
Route::apiResources(['shops' => 'API\ShopController']);
  Route::get('shops/location/{id}', 'API\ShopController@location');
Route::apiResources(['items' => 'API\ItemController']);
