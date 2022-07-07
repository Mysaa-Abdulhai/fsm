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
<<<<<<< HEAD
  ];
=======
    ];
>>>>>>> 57f92eaa12f7d8ceabd86701bf628f057b4c0de8

    public function volunteer_campaign()
    {
        return $this->belongsTo(campaign_volunteer::class, 'volunteer_campaign_id');
    }
}
