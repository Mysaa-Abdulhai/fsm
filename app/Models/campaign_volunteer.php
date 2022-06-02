<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campaign_volunteer extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(Photo::class,'photo_id');
    }
    public function volunteer_campaign()
    {
        return $this->belongsTo(Photo::class,'volunteer_campaign_id');
    }

}
