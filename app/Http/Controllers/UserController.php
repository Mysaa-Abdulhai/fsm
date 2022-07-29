<?php

namespace App\Http\Controllers;
use App\Models\campaign_like;
use App\Models\campaignSkill;
use App\Models\Profile;
use App\Models\profileSkill;
use App\Models\public_comment;
use App\Models\public_like;
use App\Models\public_post;
use App\Models\User;
use App\Models\user_role;
use App\Models\volunteer;
use App\Models\Campaign_Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\volunteer_campaign_request;
use App\Models\donation_campaign_request;
use Illuminate\Http\Request;
use App\Models\volunteer_campaign;
use App\Models\location;
use Illuminate\Support\Facades\DB ;
use phpDocumentor\Reflection\Types\Collection;

class UserController extends Controller
{

    public function show_volunteer_campaign(){
        if (volunteer_campaign::exists())
        {
            $camp=collect();
            $campaigns = volunteer_campaign::all();

            foreach ($campaigns as $campaign)
            {
                $skills=$campaign->getSkill();
                $camp->push([$campaign,$skills]);
            }
            return response()->json([
                'campaigns' => $camp,
            ], 200);
        }
        else
            return response()->json([
                'message' => 'no any campaign',
                ], 400);
        }

    public function show_details_of_volunteer_campaign(Request $request){
        $validator = Validator::make($request->all(), [
            'id'     => 'required|int',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
        if(volunteer_campaign::where('id', $request->id)->exists())
        {
            $campaign = volunteer_campaign::where('id', $request->id)->first();
            $id=$campaign->leader_id;
            $skills=$campaign->getSkill();
            $name=user::select('name')->where('id','=',$id)->first();
            return response()->json([
                'name'=>$campaign->name,
                'image'=>$campaign->image,
                'details'=>$campaign->details,
                'type'=>$campaign->type,
                'longitude'=>$campaign->longitude,
                'latitude'=>$campaign->latitude,
                'maxDate'=>$campaign->maxDate,
                'leader_name' => $name->name,
                'age'=>$campaign->age,
                'study'=>$campaign->study,
                'skills'=>$skills,
                'current_volunteer_number' => $campaign->current_volunteer_number,
                'volunteer_number' => $campaign->volunteer_number,
            ], 200);
        }
        else
            return response()->json([
                'message' => 'your campaign not found',
            ], 400);
    }

    public function volunteer_campaign_request(Request $request){
        $validator= Validator::make($request->all(), [
            'name'=>'required|string',
            'image'=>'required',
            'details'=>'required|string',
            'type'     => 'required|string',
            'volunteer_number'     => 'required|int',
            'maxDate'     => 'required|date',
            'country'  => 'required|string',
            'city'  => 'required|string',
            'street'  => 'required|string',
            'longitude' => 'required|numeric|between:-90.00000000,90.00000000',
            'latitude' => 'required|numeric|between:-90.00000000,90.00000000',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);




        //image
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move('images', $image_name);

        $location=new location();
        $location->country=$request->country;
        $location->city=$request->city;
        $location->street=$request->street;
        $location->save();

        $campaign_request=new volunteer_campaign_request();
        $campaign_request->name=$request->name;
        $campaign_request->type=$request->type;
        $campaign_request->details =$request->type;
        $campaign_request->volunteer_number=$request->volunteer_number;
        $campaign_request->maxDate=$request->maxDate;
        $campaign_request->image=$image_name;
        $campaign_request->user_id=auth()->user()->id;
        $campaign_request->location_id=$location->id;
        $campaign_request->longitude=$request->longitude;
        $campaign_request->latitude=$request->latitude;
        $campaign_request->save();

        return response()->json([
                    'message'  => 'request added Successfully',
                    'campaign_request'  => $campaign_request,
        ],200);
    }

    public function donation_campaign_request(Request $request){
        $validator= Validator::make($request->all(), [
            'name'=>'required|string',
            'description'     => 'required|string',
            'total_value'     => 'required|int',
            'end_at'     => 'required|int',
            'image' => 'required|string',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);

        $campaign_request=new donation_campaign_request();
        $campaign_request->name=$request->name;
        $campaign_request->description=$request->description;
        $campaign_request->total_value=$request->total_value;
        $campaign_request->end_at=$request->end_at;
        $campaign_request->image=$request->image;
        $campaign_request->user_id=auth()->user()->id;
        $campaign_request->save();
        return response()->json([
            'message'  => 'request added Successfully',
            'campaign_request'  => $campaign_request,
        ],200);
    }


    public function show_public_posts(Request $request){
        $po=public_post::all();
        $posts=collect();
        foreach ($po as$post)
        {
            $like=public_like::where('public_post_id','=',$post->id)->count();
            $comment=public_comment::where('public_post_id','=',$post->id)->get();
            $posts->push([$post,$like,$comment]);
        }
        return response()->json([
            'post'  => $posts,
        ],200);
    }

    public function show_posts_of_campaign(Request $request){
        $validator=Validator::make($request->all(),[
            'id' => 'required|int',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
        $po=Campaign_Post::all()->where('volunteer_campaign_id',$request->id)->get();
        $posts=collect();
        foreach ($po as $post)
        {
            $like=campaign_like::where('Campaign_Post_id','=',$post->id)->count();
            $posts->push([$post,$like]);
        }
        return response()->json([
            'post' =>$posts,
            'message' => 'all posts for campaign number'
        ],200);
    }

    public function join_campaign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required|int',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);

        $pro=Profile::where('user_id', '=', auth()->user()->id)->first();
        $camp=volunteer_campaign::where('id','=',$request->campaign_id)->first();
        $campSkills=campaignSkill::where('volunteer_campaign_id','=',$camp->id)->pluck('name');
        $proSkills=profileSkill::where('Profile_id','=',$pro->id)->pluck('name');
        $campSkills->toArray();
        $proSkills->toArray();
        $accept=false;
        if($campSkills->diff($proSkills)->isEmpty())
        {
            $accept=true;
        }
        $age = Carbon::parse($pro->birth_date)->diff(Carbon::now())->y;
            if($pro->study==$camp->study
            &&$accept==true
            &&$age>=$camp->age
            )
            {

                $volunteer = new volunteer;
                $volunteer->user_id = auth()->user()->id;
                $volunteer->volunteer_campaign_id = $request->campaign_id;
                $volunteer->save();

                $user_role= new user_role([
                    'user_id'=> auth()->user()->id,
                    'role_id'=> 4
                ]);
                $user_role->save();

                return response()->json([
                    'message' => 'you join the campaign'
                ], 200);
            }

            else
              {
                  return response()->json([
                   'message' => 'you haven\'t the requirement of campaign'
              ], 400);
           }

    }


    public function add_profile(Request $request){
        $validator = Validator::make($request->all(),[
            'name'       => 'required|string',
            'bio'       => 'required|string',
            'study'       => 'required|string',
            'image'       => 'required',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        //image
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move('images', $image_name);



        $user_pro = new Profile();
        $user_pro->name      = $request->name;
        $user_pro->bio  = $request->bio;
        $user_pro->study  = $request->study;
        $user_pro->image       = $image_name ;
        $user_pro->user_id     = auth()->user()->id;
        if(!is_null($request->nationality))
        {
            $user_pro->nationality = $request->nationality ;
        }
        if(!is_null($request->gender))
        {
            $user_pro->gender = $request->gender ;
        }
        if(!is_null($request->birth_date))
        {
            $user_pro->birth_date = $request->birth_date     ;
        }
        if(!is_null($request->leaderInFuture))
        {
            $user_pro->leaderInFuture = $request->leaderInFuture ;
        }
        if(!is_null($request->phoneNumber))
        {
            $user_pro->phoneNumber = $request->phoneNumber ;
        }

        $user_pro->save();

        if(!is_null($request->skills))
        {
            $array=$request->skills;
            $array=explode(",",$array);
            foreach($array as $skill)
            {
                profileSkill::create(['name'=>$skill,'Profile_id'=>$user_pro->id]);
            }
        }
        $skills=profileSkill::where('Profile_id','=',$user_pro->id)->pluck('name');
        return response()->json([
            'your_profile' => $user_pro,
            'skills'=>$skills,
            'message' => ' your profile created successfully '
        ],200);
    }


    public function update_profile(Request $request){

        $id=auth()->user()->id;
        if(Profile::where('user_id','=',$id)->exists())
        {
            $pro=Profile::where('user_id','=',$id)->first();
            if(is_null($request->image) And is_null($request->birth_date) And is_null($request->gender)
                And is_null($request->nationality)And is_null($request->bio)And is_null($request->name)
                And is_null($request->study) And is_null($request->skills)And is_null($request->leaderInFuture)
                And is_null($request->phoneNumber)
            ){
                return response()->json([
                    'message' => 'enter information to update your profile',
                    'campaign is' => $pro
                ]);
            }
            if(!is_null($request->image))
            {
                //image
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move('images', $image_name);
                $pro->image = $image_name ;
                $pro->save();
            }
            if(!is_null($request->birth_date))
            {
                $pro->birth_date = $request->birth_date ;
                $pro->save();
            }
            if(!is_null($request->name))
            {
                $pro->name = $request->name ;
                $pro->save();
            }
            if(!is_null($request->gender)) {
                $pro->gender = $request->gender;
                $pro->save();
            }
            if(!is_null($request->bio))
            {
                $pro->bio = $request->bio ;
                $pro->save();
            }
            if(!is_null($request->nationality))
            {
                $pro->nationality = $request->nationality ;
                $pro->save();
            }
            if(!is_null($request->study))
            {
                $pro->study = $request->study ;
                $pro->save();
            }
            if(!is_null($request->skills))
            {
                profileSkill::select('name')->where('Profile_id','=',$pro->id)->delete();
                $array=$request->skills;
                $array=explode(",",$array);
                foreach($array as $skill)
                {
                    profileSkill::create(['name'=>$skill,'Profile_id'=>$pro->id]);
                }
                $skills=profileSkill::select('name')->where('Profile_id','=',$pro->id)->get();
            }
            if(!is_null($request->leaderInFuture))
            {
                $pro->leaderInFuture = $request->leaderInFuture ;
                $pro->save();

            }
            if(!is_null($request->phoneNumber))
            {
                $pro->phoneNumber = $request->phoneNumber ;
                $pro->save();
            }

            else
                return response()->json([
                    'message' => 'your profile updated successfully',
                    'profile' => $pro,
                    'skills'=>$skills,
                ]);
        }
        else
            return response()->json([
                'message' => ' you haven\'t profile to update it '
            ],200);

    }


    public function show_profile(){

        if(Profile::where('user_id', auth()->user()->id)->exists())
        {
            $pro = Profile::where('user_id', auth()->user()->id)->first();
            $skills=profileSkill::select('name')->where('Profile_id','=',$pro->id)->get();

            return response()->json([
                'profile'=>$pro,
                'skills'=>$skills,
                ],200);
        }
        else
            return response()->json([
                'message' => 'you haven\'t a profile',
            ], 400);

    }

    public function add_public_comment(Request $request){
        $validator = Validator::make($request->all(),[
            'id'       => 'required|int',
            'text'       => 'required|string',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        if(public_post::where('id','=',$request->id)->exists())
        {
            $comment=public_comment::create([
                'user_id'=>auth()->user()->id,
                'public_post_id'=>$request->id,
                'text'=>$request->text
            ]);
            return response()->json([
                'message' => 'comment added successfully',
                'comment'=>$comment
            ], 200);
        }
        else
            return response()->json([
                'message' => 'your post not found',
            ], 403);
    }

    public function add_public_like(Request $request){
        $validator = Validator::make($request->all(),[
            'id'       => 'required|int',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        if(public_post::where('id','=',$request->id)->exists())
        {
            public_like::create([
                'user_id'=>auth()->user()->id,
                'public_post_id'=>$request->id,
            ]);
            return response()->json([
                'message' => 'you liked the post',
                'number of likes on post' => public_like::where('public_post_id','=',$request->id)->count()
            ], 200);
        }
        else
            return response()->json([
                'message' => 'your post not found',
            ], 403);
    }

    public function unlike_public(Request $request){
        $validator = Validator::make($request->all(),[
            'id'       => 'required|int',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        if(public_post::where('id','=',$request->id)->exists())
        {
            if(public_like::where('public_post_id','=',$request->id AND 'user_id','=',auth()->user()->id)->exists())
            {
                public_like::where('public_post_id','=',$request->id AND 'user_id','=',auth()->user()->id)->delete();
            }
            return response()->json([
                'message' => 'you unliked the post',
            ], 200);
        }
        else
            return response()->json([
                'message' => 'your post not found',
            ], 403);
    }

    public function add_campaign_like(Request $request){
        $validator = Validator::make($request->all(),[
            'id'       => 'required|int',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        if(Campaign_Post::where('id','=',$request->id)->exists())
        {
            campaign_like::create([
                'user_id'=>auth()->user()->id,
                'Campaign_Post_id'=>$request->id,
            ]);
            return response()->json([
                'message' => 'you liked the post',
                'number of likes on post' => public_like::where('Campaign_Post_id','=',$request->id)->count()
            ], 200);
        }
        else
            return response()->json([
                'message' => 'your post not found',
            ], 403);
    }

    public function unlike_campaign(Request $request){
        $validator = Validator::make($request->all(),[
            'id'       => 'required|int',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        if(Campaign_Post::where('id','=',$request->id)->exists())
        {
            if(campaign_like::where('Campaign_Post_id','=',$request->id AND 'user_id','=',auth()->user()->id)->exists())
            {
                campaign_like::where('public_post_id','=',$request->id AND 'user_id','=',auth()->user()->id)->delete();
            }
            return response()->json([
                'message' => 'you unliked the post',
            ], 200);
        }
        else
            return response()->json([
                'message' => 'your post not found',
            ], 403);
    }

}
