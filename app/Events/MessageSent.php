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


    public function __construct(chatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;

    }
    public function broadcastAs() {
        return 'message.new';
    }
    public function broadcastOn(): Channel
    {
        return new Channel('chat.'.$this->chatMessage->chat_room_id);
    }
}

