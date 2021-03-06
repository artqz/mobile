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
    Route::get('users/self', 'API\UserController@self');
    Route::get('chat/users_online', 'API\ChatController@users_online');
    Route::apiResources(['chat' => 'API\ChatController']);
    Route::get('battles/current', 'API\BattleController@current');
    Route::post('battles/attack', 'API\BattleController@attack');
    Route::apiResources(['battles' => 'API\BattleController']);
    Route::post('pve/attack', 'API\PveController@attack');
    Route::get('pve/current', 'API\PveController@current');
    Route::apiResources(['pve' => 'API\PveController']);
    Route::get('locations/spawn/{id}', 'API\AreaController@show');
    Route::get('shops/location/{id}', 'API\ShopController@location');
    Route::apiResources(['shops' => 'API\ShopController']);
    Route::apiResources(['items' => 'API\ItemController']);
    Route::get('users/in_battle', 'API\UserController@in_battle');
    Route::get('users/equip_item/{id}', 'API\UserController@equip_item');
    Route::get('users/remove_item/{id}', 'API\UserController@remove_item');
    Route::get('users/get_gold', 'API\UserController@get_gold');
    Route::apiResources(['users' => 'API\UserController']);
});
Route::apiResources(['locations' => 'API\LocationController']);
