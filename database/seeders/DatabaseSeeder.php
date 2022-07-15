<?php

namespace Database\Seeders;

use App\Models\ChatRoom;
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
              ],
              [
                  'name'=>'volunteer'
              ],
            ];
        Role::insert($roles);

        $permission=
            [
                [
                    'name'=>'all_volunteer_campaign_request',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'all_donation_campaign_request',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'all_volunteer_form',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'response_on_volunteer_campaign_request',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'response_on_donation_campaign_request',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'add_volunteer_campaign',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'update_volunteer_campaign',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'delete_volunteer_campaign',
                    'role_id'=>'1'
                ],


                [
                    'name'=>'add_public_post',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'update_public_Posts',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'delete_public_post',
                    'role_id'=>'1'
                ],



                //user
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
                    'name'=>'show_public_posts',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'show_posts_of_campaign',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'join_campaign',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'add_profile',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'update_profile',
                    'role_id'=>'2'
                ],






                //leader
              [
                  'name'=>'add_campaign_post',
                  'role_id'=>'3'
              ],



            ];
        permission::insert($permission);
    }
}
