<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public function Permission(){
        return $this->hasMany(Permission::class)
            ->select('role_id','name');
    }

    public function check($name)
    {
        $permission=Permission::query()->where('name','=',$name)->first();
        return Permission::query()->where('role_id','=',$this->id)->exists();
    }

    public function user_role()
    {
        return $this->hasMany(user_role::class);
    }
}
