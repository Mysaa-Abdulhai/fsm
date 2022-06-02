<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class volunteer_form extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(user::class);
    }
    public function photo()
    {
        return $this->belongsTo(photo::class,'photo_id');
    }
    public function location()
    {
        return $this->belongsTo(location::class,'location_id');
    }
}
