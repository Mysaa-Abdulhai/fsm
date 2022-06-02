<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donation_campaign extends Model
{
    use HasFactory;
    public function donation_campaign_request()
    {
        return $this->belongsTo(donation_campaign_request::class);
    }
}
