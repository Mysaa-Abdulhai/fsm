<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $roles=
            [
              [
                  'name'=>'admin'
              ],
              [
                  'name'=>'user'
              ],
              [
                  'name'=>'leader'
              ]
            ];
        Role::insert($roles);

        $permission=
            [
                [
                    'name'=>'gogogaaga',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'show_volunteer_campaign',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'show_details_of_volunteer_campaign',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'volunteer_campaign_request',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'donation_campaign_request',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'volunteer_form',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'show_public_posts',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'show_posts_of_campaign',
                    'role_id'=>'2'
                ],
//              [
//                  'name'=>'admin',
//                  'role_id'=>'3'
//              ],
            ];
        permission::insert($permission);
    }
}
