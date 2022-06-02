<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'src', //the path you uploaded the image
        'mime_type',
        'description',
        'alt',
  ];
    public function volunteer_form()
    {
        return $this->hasOne(volunteer_form::class);
    }
    public function donation_campaign_request()
    {
        return $this->hasOne(donation_campaign_request::class);
    }
    public function volunteer_campaign_request()
    {
        return $this->hasOne(volunteer_campaign_request::class);
    }
}
