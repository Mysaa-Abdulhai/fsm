<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign_Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'photo',
    ];

    public function volunteer_campaign()
    {
        return $this->belongsTo(campaign_volunteer::class, 'volunteer_campaign_id');
    }
}
