<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'chat_room_id',
        'user_id',
        'message',
        'name',
    ];
    public function room()
    {
        return $this->belongsTo('App\Models\ChatRoom','chat_room_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
