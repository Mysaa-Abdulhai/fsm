<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donation_campaign_request extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'goal',
        'end_at',
        'seenAndAccept',
        'image',
    ];
    public function user()
    {
        return $this->belongsTo(user::class,'user_id');
    }
}
