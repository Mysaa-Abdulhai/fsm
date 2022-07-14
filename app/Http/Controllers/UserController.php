<?php

namespace App\Http\Controllers;
use App\Models\Profile;
use App\Models\public_post;
use App\Models\User;
use App\Models\user_role;
use App\Models\volunteer;
use App\Models\Campaign_Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\volunteer_campaign_request;
use App\Models\donation_campaign_request;
use Illuminate\Http\Request;
use App\Models\volunteer_campaign;
use App\Models\location;
use Illuminate\Validation\Rules\RequiredIf;
class UserController extends Controller
{

    public function show_volunteer_campaign(Request $request){
        if (volunteer_campaign::exists())
        {
            $campaign = volunteer_campaign::all();
            return response()->json([
                'campaign' => $campaign,
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
            $name=user::select('name')->where('id','=',$id)->first();
            return response()->json([
                'leader_name' => $name->name,
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
            'image' => 'required',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);

        //image
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move('images', $image_name);

        $campaign_request=new donation_campaign_request();
        $campaign_request->name=$request->name;
        $campaign_request->description=$request->description;
        $campaign_request->total_value=$request->total_value;
        $campaign_request->end_at=$request->end_at;
        $campaign_request->image=$image_name;
        $campaign_request->user_id=auth()->user()->id;
        $campaign_request->save();
        return response()->json([
            'message'  => 'request added Successfully',
            'campaign_request'  => $campaign_request,
        ],200);
    }


    public function show_public_posts(Request $request){
        $posts=public_post::all();
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
        $posts=Campaign_Post::all()->where('volunteer_campaign_id',$request->id)->first();

        return response()->json([
            'post' =>$posts,
            'message' => 'all posts for campaign number'
        ],200);
    }

    public function join_campaign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'user_id' => 'required|int',
            'campaign_id' => 'required|int',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);

        $pro=Profile::where('user_id', '=', auth()->user()->id)->first();
        $camp=volunteer_campaign::where('id','=',$request->campaign_id)->first();
        $age = Carbon::parse($pro->birth_date)->diff(Carbon::now())->y;
            if($pro->study==$camp->study
            &&$pro->skills==$camp->skills
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
                   'message' => 'you havn\'t the requirement of campaign'
              ], 400);
           }

    }


    public function add_profile(Request $request){
        $validator = Validator::make($request->all(),[
            'name'        => 'required|string',
            'gender'      => 'required|string',
            'birth_date'  => 'required|date',
            'image'       => 'required',
//            'nationality' => 'required|string',
//            'study'       => 'required|string',
//            'skills'      => 'required|string',
//            'leaderInFuture'      => 'required|boolean',
//            'phoneNumber' => 'required|int',
//            'city'       => 'required|string',
//            'country'       => 'required|string',
//            'street'       => 'required|string',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        //image
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move('images', $image_name);



        $user_pro = new Profile();
        $user_pro->name        = $request->name;
        $user_pro->gender      = $request->gender;
        $user_pro->birth_date  = $request->birth_date;
        $user_pro->image       = $image_name ;
        $user_pro->user_id     = auth()->user()->id;

        if(!is_null($request->nationality))
        {
            $user_pro->nationality = $request->nationality ;
        }
        if(!is_null($request->city)
        &&!is_null($request->country)
        && !is_null($request->street))
        {
            $location = new location();
            $location->country = $request->country;
            $location->city    = $request->city;
            $location->street  = $request->street;
            $location->save();
            $user_pro->location_id = $location->id;

        }
        if(!is_null($request->study))
        {
            $user_pro->study = $request->study ;
        }
        if(!is_null($request->skills))
        {
            $user_pro->skills = $request->skills ;
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
        return response()->json([
            'your_profile' => $user_pro,
            'message' => ' your profile created successfully '
        ]);
    }//end



}
