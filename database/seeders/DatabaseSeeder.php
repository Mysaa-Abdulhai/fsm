<?php

namespace Database\Seeders;

use App\Models\ChatRoom;
use App\Models\User;
use App\Models\user_role;
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
        $user=
            [
              'name'=>'Aziz',
              'email'=>'aboda123.azoz56@gmail.com',
              'password'=>bcrypt('azoz123'),
              'is_verified'=>'1',
            ];
        User::insert($user);

        $user_role=
           [ [
                'user_id'=>1,
                'role_id'=>1,
            ],
        [
            'user_id'=>1,
            'role_id'=>2,
        ]];
        user_role::insert($user_role);

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
                    'name'=>'acceptAndUnanswered',
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
                [
                    'name'=>'all_user_leader_in_future',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'all_convert_points_request',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'response_on_convert_points_request',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'male_and_female',
                    'role_id'=>'1'
                ],
                [
                    'name'=>'campaigns_in_category',
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
                [
                    'name'=>'show_profile',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'add_public_comment',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'public_post_like',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'campaign_post_like',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'favorite_campaign',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'delete_favorite_campaign',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'add_rate',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'update_rate',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'search_name',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'statistics_likes',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'statistics_accepted_requests',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'statistics_campaigns',
                    'role_id'=>'2'
                ],
                [
                      'name'=>'get_favorite',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'convert_points_request',
                    'role_id'=>'2'
                ],
                [
                    'name'=>'campaign_suggestions',
                    'role_id'=>'2'
                ],






                //leader
              [
                  'name'=>'add_campaign_post',
                  'role_id'=>'3'
              ],
              [
                  'name'=>'add_points',
                  'role_id'=>'3'
              ],



              //volunteer
              [
                  'name'=>'chat/room',
                  'role_id'=>'4'
              ],
              [
                  'name'=>'chat/room/message',
                  'role_id'=>'4'
              ],
            ];
        permission::insert($permission);
        $this->call([
            users::class,
        ]);
    }
}
