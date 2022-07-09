<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leader extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];
    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function volunteer_campaigns() {
        return $this->hasMany(volunteer_campaign::class);
    }
}
