<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'volunteer_campaign_id'
    ];
    public function messages()
    {
        return $this->hasMany('App\Models\ChatMessage');
    }
    public function volunteer_campaign()
    {
        return $this->belongsTo(volunteer_campaign::class,'volunteer_campaign_id');
    }
}
