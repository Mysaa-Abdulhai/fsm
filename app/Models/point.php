<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class point extends Model
{
    use HasFactory;
    protected $fillable=['value','user_id'];
    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
