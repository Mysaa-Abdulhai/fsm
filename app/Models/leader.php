<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\campaign_volunteer;

class leader extends Model
{
    use HasFactory;

    public function volunteer_campaign() {
        return $this->hasMany(related: volunteer_campaign::class);
    }
}