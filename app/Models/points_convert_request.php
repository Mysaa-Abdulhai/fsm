<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class points_convert_request extends Model
{
    use HasFactory;
    protected $fillable=['value','user_id','seenAndAccept'];
    public function User()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
