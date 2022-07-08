<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation_campaign extends Model
{
    use HasFactory;

    protected $fillable =[
        'name' ,
        'description',
        'total_value',
        'maxDate',
    ];

    public function donation_campaign_request()
    {
        return $this->belongsTo(donation_campaign_request::class);
    }
}
