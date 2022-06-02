<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donation_campaign_request extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(user::class,'user_id');
    }
    public function donation_campaign(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(donation_campaign::class);
    }
    public function photo()
    {
        return $this->belongsTo(Photo::class,'photo_id');
    }
}
