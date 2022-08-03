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
        'current_volunteer_number',
        'maxDate',
        'image',
        'age',
        'study',
        'location_id',
        'leader_id',
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
    public function Campaign_Posts()
    {
        return $this->hasMany(Campaign_Post::class);
    }
    public function volunteers()
    {
        return $this->hasMany(volunteer::class);
    }
    public function campaignSkills()
    {
        return $this->hasMany(campaignSkill::class);
    }
    public function favorites()
    {
        return $this->hasMany(favorite::class);
    }
    public function volunteer_campaign_rates()
    {
        return $this->hasMany(volunteer_campaign_rate::class);
    }


    public function getSkill()
    {
        $skills=collect();
        $x=campaignSkill::where('volunteer_campaign_id','=',$this->id)->select('name')->get();
        foreach ($x as $y)
        {
            $skills->push($y->name);
        }
        return $skills;
    }
}
