<?php

namespace App\Http\Controllers;
use App\Models\public_post;
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
            'details'=>'required|string',
            'type'     => 'required|string',
            'volunteer_number'     => 'required|int',
            'target'     => 'required|string',
            'maxDate'     => 'required|date',
            'image' => 'required',
            'country'  => 'required|string',
            'city'  => 'required|string',
            'street'  => 'required|string',

        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);


        //image
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move('public/storage/images', $image_name);


        $location=new location();
        $location->country=$request->country;
        $location->city=$request->city;
        $location->street=$request->street;
        $location->save();

        $campaign_request=new volunteer_campaign_request();
        $campaign_request->type=$request->type;
        $campaign_request->details =$request->type;
        $campaign_request->volunteer_number=$request->volunteer_number;
        $campaign_request->target=$request->target;
        $campaign_request->maxDate=$request->maxDate;
        $campaign_request->image=$request->$image_name;
        $campaign_request->user_id=auth()->user()->id;
        $campaign_request->location_id=$location->id;
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
            'maxDate'     => 'required|date',
            'image' => 'binary',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);

        $campaign_request=new donation_campaign_request();
        $campaign_request->name=$request->name;
        $campaign_request->description =$request->description;
        $campaign_request->total_value=$request->total_value;
        $campaign_request->maxDate=$request->maxDate;
        $campaign_request->image=$request->image;
        $campaign_request->user_id=auth()->user()->id;
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
                'image' =>'binary',
                'country' => 'required|string',
                'city' => 'required|string',
                'street' => 'required|string',
          ]);

        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);

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
        $volunteer_form->image=$request->image;
        $volunteer_form->location_id=$location->id;
        $volunteer_form->user_id=auth()->user()->id;

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
        $posts=Campaign_Post::all()->where('volunteer_campaign_id',$request->id);

        return response()->json([
            'post' =>$posts,
            'message' => 'all posts for campaign number'
        ]);
    }

}
