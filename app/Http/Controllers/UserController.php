<?php

namespace App\Http\Controllers;
use App\Models\public_post;
use App\Models\volunteer;
use App\Models\volunteer_form;
use App\Models\Campaign_Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\volunteer_campaign_request;
use App\Models\donation_campaign_request;
use Illuminate\Http\Request;
use App\Models\volunteer_campaign;
use App\Models\location;
class UserController extends Controller
{

    public function show_volunteer_campaign(Request $request){
        $campaign=volunteer_campaign::all();
        return response()->json([
            'campaign'  => $campaign,
        ],200);
    }

    public function show_details_of_volunteer_campaign(Request $request){
        $validator = Validator::make($request->all(), [
            'id'     => 'required|int',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
        $campaign = volunteer_campaign::where('id',$request->id)->first();
        return response()->json([
            'campaign'  => $campaign,
        ],200);
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
            'latitude' => 'required|numeric|between:-90,90'
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

    public function volunteer_form(Request $request){
        $validator=Validator::make($request->all(),[
                'name' => 'required|string|unique:volunteer_forms,name',
                'age' => 'required|int',
                'nationality' => 'required|string',
                'study' => 'required|string',
                'skills' => 'required|string',
                'phoneNumber' => 'required|int|unique:volunteer_forms,phoneNumber',
                'image' =>'required',
                'country' => 'required|string',
                'city' => 'required|string',
                'street' => 'required|string',
                'leaderInFuture'=>'required|boolean'
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

        $volunteer_form=new volunteer_Form();
        $volunteer_form->name=$request->name;
        $volunteer_form->age=$request->age;
        $volunteer_form->nationality=$request->nationality;
        $volunteer_form->study=$request->study;
        $volunteer_form->skills=$request->skills;
        $volunteer_form->phoneNumber=$request->phoneNumber;
        $volunteer_form->image=$image_name;
        $volunteer_form->location_id=$location->id;
        $volunteer_form->leaderInFuture=$request->leaderInFuture;
        $volunteer_form->user_id=auth()->user()->id;
        $volunteer_form->save();

        return response()->json([
            'message'  => 'form added Successfully',
            'volunteer_form'  => $volunteer_form,
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
    public function join_capaign(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'user_id' => 'required|int',
            'campaign_id' => 'required|int',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);

        if(true)
        {
            $volunteer=new volunteer;
            $volunteer->user_id=$request->campaign_id;
            $volunteer->volunteer_campaign_id=$request->campaign->id;
            $volunteer->save();

            return response()->json([
                'message'=>'you join the campaign'
            ],200);
        }
        else
        {
            return response()->json([
                'message' => 'you havn\'t the requirement of campaign'
            ], 400);
        }
    }

}
