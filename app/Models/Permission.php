<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
<<<<<<< HEAD

    public function role(){
        return $this->belongsto(Role::class);
=======
    protected $fillable = [
        'name',
        'role_id'
    ];
    protected $hidden = [
        'pivot'
    ];
    public function roles(){
        return $this->belongsto(Role::class,'role_id');
>>>>>>> 57f92eaa12f7d8ceabd86701bf628f057b4c0de8
    }
}
