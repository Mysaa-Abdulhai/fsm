<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification_token extends Model
{
    use HasFactory;
    protected $fillable=[
        'token',
        'user_id'
    ];

public function User()
{
    return $this->belongsTo(User::class,'user_id');
}
}
