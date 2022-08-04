<?php

namespace App\Http\Controllers;

use App\Models\Campaign_Post;
use App\Models\point;
use App\Models\volunteer;
use App\Models\volunteer_campaign;
use Carbon\Carbon;
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
            'point_for_all'     => 'required|int',
            'point_for_distinguished'   => 'required|int',
            'ids'=>'required'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);



            $date=volunteer_campaign::where('id','=',$request->volunteer_campaign_id)->first();
            $date=Carbon::parse($date->maxDate)->diff(Carbon::now())->days;
            if($date>=0)
            {
                $array = $request->ids;
                $array = explode(",", $array);
                foreach ($array as $id) {
                    if(volunteer::where('user_id','=',$id)->where('volunteer_campaign_id','=',$request->volunteer_campaign_id)->exists())
                    {
                        if (point::where('user_id', '=', $id)->exists())
                        {
                            $current = point::where('user_id', '=', $id)->first();
                            $current = $current->value;
                            $new=$current+$request->point_for_distinguished;
                            point::where('user_id', '=', $id)->update(['value' => $new]);
                        }
                        else
                        {
                            point::create([
                                'user_id' => $id,
                                'value' => $request->point_for_distinguished
                            ]);
                        }
                    }
                }
                $users=volunteer::where('volunteer_campaign_id','=',$request->volunteer_campaign_id)->pluck('user_id');
                foreach ($users as $user)
                {
                    if(point::where('user_id','=',$user)->exists())
                    {

                        $current = point::where('user_id', '=', $user)->first();
                        $current = $current->value;
                        $new=$current+$request->point_for_all;
                        point::where('user_id','=',$user)->update(['value'=>$new]);
                    }
                    else
                    {
                        point::create([
                            'user_id'=>$user,
                            'value'=>$request->point_for_all
                            ]);
                    }
                }
            }
            else
                return response()->json([
                    'message'=>'This campaign is not over',
                ],403);

    }
}
