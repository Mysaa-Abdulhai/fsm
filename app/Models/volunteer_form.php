<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class volunteer_form extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'total_value',
        'maxDate',
        'image'
    ];
    public function user()
    {
        return $this->belongsTo(user::class,'user_id');
    }
    public function location()
    {
        return $this->belongsTo(location::class,'location_id');
    }
}
