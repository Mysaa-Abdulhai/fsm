<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donation_campaign_request extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'end_at',
        'total_value',
        'seenAndAccept',
        'image',
    ];
    public function user()
    {
        return $this->belongsTo(user::class,'user_id');
    }
}
