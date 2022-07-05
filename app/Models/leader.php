<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\campaign_volunteer;

class leader extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(volunteer_campaign::class,'user_id');
    }

    public function volunteer_campaigns() {
        return $this->hasMany(volunteer_campaign::class);
    }
}
