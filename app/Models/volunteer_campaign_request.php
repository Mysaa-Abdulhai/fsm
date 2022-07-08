<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class volunteer_campaign_request extends Model
{
    use HasFactory;
    protected $fillable = [
        'details',
        'type',
        'volunteer_number',
        'target',
        'maxDate',
        'image',
    ];
    public function user()
    {
        return $this->belongsTo(user::class,'user_id');
    }
    public function volunteer_campaign()
    {
        return $this->hasOne(volunteer_campaign::class);
    }
    public function location()
    {
        return $this->belongsTo(location::class,'location_id');
    }
}
