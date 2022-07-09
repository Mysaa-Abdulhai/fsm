<?php

namespace App\Http\Controllers;

use App\Models\Campaign_Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    public function chat(Request $request){

    }

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
        $image->storeAs('public/images', $image_name);


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

    public function get_volunteer_of_campaign(Request $request,$id){

    }

}
