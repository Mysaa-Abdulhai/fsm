<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class volunteer_campaign extends Model
{
    use HasFactory;
    public function volunteer_campaign_request()
    {
        return $this->belongsTo(related: volunteer_campaign_request::class);
    }
    public function user()
    {
        return $this->belongsTo(related: User::class);
    }
    public function campaign_volunteers()
    {
        return $this->hasMany(campaign_volunteer::class);
    }
}
