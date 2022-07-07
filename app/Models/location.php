<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    use HasFactory;
    protected $fillable = [
        'country',
        'city',
        'street',
    ];
    public function donation_campaign_request()
    {
        return $this->hasOne(donation_campaign_request::class);
    }
    public function volunteer_campaign_request()
    {
        return $this->hasOne(volunteer_campaign_request::class);
    }
}
