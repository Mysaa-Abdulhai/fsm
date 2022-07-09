<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class volunteer extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function volunteer_campaign()
    {
        return $this->belongsTo(volunteer_campaign::class,'volunteer_campaign_id');
    }
}
