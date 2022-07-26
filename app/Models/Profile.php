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
        'bio',
        'age',
        'nationality',
        'study',
        'phoneNumber',
        'leaderInFuture',
        'image',
        ];
    use HasFactory;
    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function profileSkill()
    {
        return $this->hasMany(profileSkill::class);
    }
}
