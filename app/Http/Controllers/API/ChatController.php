<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
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
        $user_id = $request->user()->id;
        $messages_count = Message::where('receiver_id', $user_id)
            ->orWhere('receiver_id', 0)
            ->count();
        $messages = Message::orderBy('created_at', 'ASC')
            ->where('receiver_id', $user_id)
            ->orWhere('receiver_id', 0)
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
        $message = new Message;
        $message->sender_id = $request->user()->id;
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
