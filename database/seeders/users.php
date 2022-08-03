<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Models\user_role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::insert([
            ['name'=>'sami','password'=>bcrypt('sami123'),'email'=>'sami@gmail.com','is_verified'=>1],
            ['name'=>'salim','password'=>bcrypt('salim123'),'email'=>'salim@gmail.com','is_verified'=>1],
            ['name'=>'azizi','password'=>bcrypt('aziz123'),'email'=>'azizi@gmail.com','is_verified'=>1],
            ['name'=>'joseph','password'=>bcrypt('joseph123'),'email'=>'joseph@gmail.com','is_verified'=>1],
            ['name'=>'shaker','password'=>bcrypt('shaker123'),'email'=>'shaker@gmail.com','is_verified'=>1],
        ]);

        user_role::insert([
            [
                'user_id'=>2,
                'role_id'=>2,
            ],
            [
                'user_id'=>3,
                'role_id'=>2,
            ],
            [
                'user_id'=>4,
                'role_id'=>2,
            ],
            [
                'user_id'=>5,
                'role_id'=>2,
            ],
            [
                'user_id'=>6,
                'role_id'=>2,
            ],
        ]);
        Profile::insert([
            [
                'user_id'=>2,
                'name'=>'sdf',
                'gender'=>'dsf',
                'bio'=>'ew',
                'birth_date'=>'2002-08-08',
                'nationality'=>'afsd',
                'study'=>'df',
                'phoneNumber'=>'234234',
                'leaderInFuture'=>1,
                'image'=>'dsfds',
            ],
            [
                'user_id'=>3,
                'name'=>'sdf',
                'gender'=>'dsf',
                'bio'=>'ew',
                'birth_date'=>'2002-08-08',
                'nationality'=>'afsd',
                'study'=>'df',
                'phoneNumber'=>'234234',
                'leaderInFuture'=>1,
                'image'=>'dsfds',
            ],
            [
                'user_id'=>4,
                'name'=>'sdf',
                'gender'=>'dsf',
                'bio'=>'ew',
                'birth_date'=>'2002-08-08',
                'nationality'=>'afsd',
                'study'=>'df',
                'phoneNumber'=>'234234',
                'leaderInFuture'=>1,
                'image'=>'dsfds',
            ],
            [
                'user_id'=>5,
                'name'=>'sdf',
                'gender'=>'dsf',
                'bio'=>'ew',
                'birth_date'=>'2002-08-08',
                'nationality'=>'afsd',
                'study'=>'df',
                'phoneNumber'=>'234234',
                'leaderInFuture'=>1,
                'image'=>'dsfds',
            ],
            [
                'user_id'=>6,
                'name'=>'sdf',
                'gender'=>'dsf',
                'bio'=>'ew',
                'birth_date'=>'2002-08-08',
                'nationality'=>'afsd',
                'study'=>'df',
                'phoneNumber'=>'234234',
                'leaderInFuture'=>1,
                'image'=>'dsfds',
            ],
        ]);

    }
}
