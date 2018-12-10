<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Chat;
use App\Http\Resources\Chat as ChatResource;
use App\Http\Resources\User as UserResource;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages_count = Chat::count();
        $messages = Chat::orderBy('created_at', 'ASC')
            ->offset($messages_count-30)
            ->limit(30)
            ->get();
        User::where('id', $request->user()->id)->update(['active_at' => \Carbon\Carbon::now()]);
        return ChatResource::collection($messages);
    }

    public function users_online()
    {
        $users = User::where('active_at', '>', \Carbon\Carbon::now()->subSeconds(60))->get();
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Chat;
        $message->user_id = $request->user()->id;
        $message->text = $request->input('message');
        if($message->save()) {
            return new ChatResource($message);
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
