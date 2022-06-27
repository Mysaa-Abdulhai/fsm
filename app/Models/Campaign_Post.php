<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compaign_Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'photo',
        //'slug'
  ];

    public function campaign_volunteer()
    {
        return $this->belongsTo(campaign_volunteer::class );
    }
    
    public function learder()
    {
        return $this->belongsTo(leader::class );
    }

}
