<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class volunteer_campaign_rate extends Model
{
    use HasFactory;
    protected $fillable=['user_id','volunteer_campaign_id','rate'];
    public function user()
    {
        return $this->belongsTo(related: User::class,foreignKey: 'user_id');
    }
    public function volunteer_campaign()
    {
        return $this->belongsTo(related: volunteer_campaign::class,foreignKey: 'volunteer_campaign_id');
    }
}
