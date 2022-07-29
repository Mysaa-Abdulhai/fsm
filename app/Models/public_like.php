<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class public_like extends Model
{
    use HasFactory;
    protected $fillable=['public_post_id','user_id'];
    public function public_post()
    {
        return $this->belongsTo(public_post::class,'public_post_id');
    }
    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}

