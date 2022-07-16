<?php

namespace App\Http\Controllers;

use App\Models\volunteer_campaign;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use  App\Events\MessageSent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function messages(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'room_id' => 'required|int',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
        return DB::table('chat_messages')->select('user_id','name','message')->orderBy('created_at', 'DESC')
            ->get();

    }

    public function newMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|int',
            'message' => 'required|string'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
        if (ChatRoom::where('id', $request->room_id)->exists()) {
            $newMessage = new ChatMessage;
            $newMessage->user_id = auth()->user()->id;
            $newMessage->name = auth()->User()->name;
            $newMessage->chat_room_id = $request->room_id;
            $newMessage->message = $request->message;
            $newMessage->save();

            broadcast(new MessageSent($newMessage))->toOthers();
            return response()->json([
//                $newMessage
                'Message' => 'message sent',
                'message' => $newMessage->message,
                'user' => auth()->User()->name,
                'id'=> $newMessage->user_id,
            ], 200);
        }
    }
}
