<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profileSkill extends Model
{
    use HasFactory;
    protected $fillable=['name','Profile_id'];
    public function Profiles()
    {
        return $this->belongsTo(related: Profile::class,foreignKey: 'Profile_id');
    }
}
