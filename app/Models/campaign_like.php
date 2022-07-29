<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campaign_like extends Model
{
    use HasFactory;
    protected $fillable=['Campaign_Post_id','user_id'];
    public function Campaign_Post()
    {
        return $this->belongsTo(public_post::class,'Campaign_Post_id');
    }
    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
