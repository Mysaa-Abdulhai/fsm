<?php

namespace App\Models;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function Permissions(){
        return $this->hasMany(Permission::class)
            ->select('role_id','name');
    }

    public function check($name)
    {
        $permission=Permission::query()->where('name','=',$name)->first();
        return $permission::query()->where('role_id','=',$this->id)->exists();
    }

    public function user_role()
    {
        return $this->hasMany(user_role::class);
    }
}
