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
        'image',
        'volunteer_campaign_id'
  ];
    public function volunteer_campaign()
    {
        return $this->belongsTo(volunteer_campaign::class, 'volunteer_campaign_id');
    }
}
