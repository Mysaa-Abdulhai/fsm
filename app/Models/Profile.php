<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable=[
        'name',
        'user_id',
        'gender',
        'birth_date',
        'age',
        'nationality',
        'location_id',
        'study',
        'skills',
        'phoneNumber',
        'leaderInFuture',
        'image',
        ];
    use HasFactory;
}
