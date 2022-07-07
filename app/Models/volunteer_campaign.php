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
        'target',
        'maxDate',
        'image'
    ];
//    public function user()
//    {
//        return $this->belongsTo(related: User::class);
//    }
    public function volunteer_campaign_request()
    {
        return $this->belongsTo(related: volunteer_campaign_request::class,foreignKey: 'volunteer_campaign_request_id');
    }
    public function campaign_volunteers()
    {
        return $this->hasMany(campaign_volunteer::class);
    }
    public function leader() {
        return $this->belongsTo(related: leader::class,foreignKey: 'leader_id');
    }
    public function Compaign_Posts()
    {
        return $this->hasMany(Compaign_Post::class);
    }
}
