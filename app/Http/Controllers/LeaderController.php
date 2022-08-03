<?php

namespace App\Http\Controllers;

use App\Models\Campaign_Post;
use App\Models\volunteer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    public function add_campaign_post(Request $request){
        $validator=Validator::make($request->all(),[
            'title'=>'required|string',
            'body'=>'required|string',
            'image'=>'required',
            'volunteer_campaign_id'=>'required|int'
        ]);
        if ($validator->fails()){
            return response()->json([$validator->getMessageBag()], 400);
        }

        //image
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move('images', $image_name);


        $post=new Campaign_Post();
        $post->title=$request->title;
        $post->body=$request->body;
        $post->volunteer_campaign_id=$request->volunteer_campaign_id;
        $post->image=$image_name;

        $post->save();

        return response()->json([
            'message'=>'post added successfully',
            'psot'=>$post,
        ],200);

    }

    public function add_points(Request $request){
        $validator = Validator::make($request->all(), [
            'volunteer_campaign_id'     => 'required|int',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);

        if(volunteer::where('volunteer_campaign_id','=',$request->volunteer_campaign_id)
            ->where('user_id','=',auth()->user()->id)
            ->where('is_leader','=',true)
            ->exists())
        {

        }
        else
            return response()->json([
                'message'=>'you arn\'t the leader',
            ],403);

    }
}
