<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\campaign_volunteer;

class leader extends Model
{
    use HasFactory;

    public function volunteer_campaign() {
        return $this->hasMany(volunteer_campaign::class );
    }

    public function Compaign_Post() {
        return $this->hasMany( Compaign_Post::class );
    }
    
}