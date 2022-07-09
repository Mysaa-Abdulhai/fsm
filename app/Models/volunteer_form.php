<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class volunteer_form extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'age',
        'nationality',
        'location_id',
        'study',
        'skills',
        'phoneNumber',
        'image',
    ];
    public function user()
    {
        return $this->belongsTo(user::class);
    }
    public function location()
    {
        return $this->belongsTo(location::class,'location_id');
    }
}
