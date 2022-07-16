<?php

namespace App\Events;


use App\Models\ChatMessage;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatMessage;
    public $name;
    public $message;
    public $room_id;
    public $user_id;

    public function __construct(ChatMessage $chatMessage,$message,$name,$room_id,$user_id)
    {
        $this->chatMessage = $chatMessage;
        $this->name = $name;
        $this->message = $message;
        $this->room_id = $room_id;
        $this->user_id = $user_id;
    }
    public function broadcastAs() {
        return 'message.new';
    }
    public function broadcastOn(): Channel
    {
        return new Channel('chat.'.$this->chatMessage->chat_room_id);
    }
}

