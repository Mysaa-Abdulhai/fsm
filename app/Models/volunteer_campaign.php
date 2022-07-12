<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class volunteer_campaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'details',
        'type',
        'volunteer_number',
        'maxDate',
        'image',
        'location_id',
        'longitude',
        'latitude',
    ];
//    public function user()
//    {
//        return $this->belongsTo(related: User::class);
//    }

    public function ChatRoom()
    {
        return $this->hasOne(ChatRoom::class);
    }
    public function volunteer_campaign_request()
    {
        return $this->belongsTo(related: volunteer_campaign_request::class,foreignKey: 'volunteer_campaign_request_id');
    }
    public function leader() {
        return $this->belongsTo(related: leader::class,foreignKey: 'leader_id');
    }
    public function Campaign_Posts()
    {
        return $this->hasMany(Campaign_Post::class);
    }
    public function volunteers()
    {
        return $this->hasMany(volunteer::class);
    }
}
