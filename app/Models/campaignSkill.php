<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campaignSkill extends Model
{
    use HasFactory;
    protected $fillable=['name','volunteer_campaign_id'];
    public function volunteer_campaigns()
    {
        return $this->belongsTo(related: volunteer_campaign::class,foreignKey: 'volunteer_campaign_id');
    }
}
