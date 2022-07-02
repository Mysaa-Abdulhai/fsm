<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{
    use HasFactory;
    public function users()
    {
        return $this->belongsTo(user::class,'user_id');
    }
    public function roles()
    {
        return $this->belongsTo(Role::class,'role_id');
    }
}
