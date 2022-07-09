<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\donation_campaign_request;
use App\Models\leader;
use App\Models\public_post;
use App\Models\volunteer_campaign;
use App\Models\volunteer_form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB ;
use App\Models\volunteer_campaign_request;
use Exception;

use App\Models\location;
class AdminController extends Controller
{
    public function all_volunteer_campaign_request()
    {
        return response()->json([
            'message' => 'campaign added successfully',
            'requests' => volunteer_campaign_request::all()
        ], 200);

    }

    public function all_donation_campaign_request(Request $request)
    {
        $campaigns = donation_campaign_request::where('seenAndAccept', '=', false)->get();
        return response()->json([
            'message' => 'campaign added successfully',
            'requests' => $campaigns
        ], 200);
    }

    public function all_volunteer_form()
    {
        $forms = volunteer_form::all();
        return response()->json([
            'message' => 'campaign added successfully',
            'forms' => $forms
        ], 200);
    }

    public function response_on_volunteer_campaign_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'accept' => 'required|boolean'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
        $campaign_request = volunteer_campaign_request::where('id', '=', $request->id);
        if ($request->accept) {
            $campaign = new volunteer_campaign();
            $campaign->location_id = $campaign_request->location_id;
            $campaign->image = $campaign_request->image;
            $campaign->details = $campaign_request->details;
            $campaign->type = $campaign_request->type;
            $campaign->volunteer_number = $campaign_request->volunteer_number;
            $campaign->target = $campaign_request->target;
            $campaign->maxDate = $campaign_request->maxDate;
            $campaign->save();
            $campaign_request->delete();
            $room = new ChatRoom();

            return response()->json([
                'message' => 'campaign added successfully',
                'campaign' => $campaign,
            ], 200);
        } else {
            $campaign_request->delete();
            return response()->json([
                'message' => 'request deleted',
            ], 200);
        }
    }

    public function determine_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required|int',
            'volunteer_form_id' => 'required|int'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
        $form = volunteer_form::where('id', '=', $request->volunteer_form_id);
        $leader = new leader();
        $leader->user_id = $form->user_id;
        $leader->save();
        $campaign = volunteer_campaign::where('id', '=', $request->campaign_id);
        $campaign->leader_id = $leader->id;
        return response()->json([
            'message' => 'leader set successfully',
        ], 200);
    }

    public function response_on_donation_campaign_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
        ]);
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
        $campaign_request = donation_campaign_request::where('id', '=', $request->id);
        if ($request->accept) {
            $campaign_request->seenAndAccept = true;
            $campaign_request->save();
            return response()->json([
                'message' => 'campaign added successfully',
            ], 200);
        } else {
            $campaign_request->delete();
            return response()->json([
                'message' => 'request deleted',
            ], 200);
        }
    }
    public function add_posts(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body'  => 'required|string' ,
            'image' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'error',
                $validator->getMessageBag()
            ],400);
        }

        //image
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move('public/storage/images', $image_name);

        $new_post = new public_post();
        $new_post->title = $request->title ;
        $new_post->body  = $request->body ;
        $new_post->image = $request->$image_name ;
        $new_post->save();

        return response()->json([
            'post'    => $new_post,
            'message' => 'Post added Successfully'
        ],200);
    }
    public function updatePosts(Request $request, $id){
        $post = public_post::find($id);
        if(!$post)
            return response()->json([
                'message' => 'Post you have requested not found'
            ]);
        $validator = Validator::make($request->all(),[
            'title' => 'required|string' ,
            'body'  => 'required|string' ,
            'image' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(['message' => 'pleas Enter an info to update !'],400);
        }

        //image
        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move('public/storage/images', $image_name);


        $post->title = $request->title ;
        $post->body = $request->body ;
        $post->photo = $image_name;

        $post->save();
        return response()->json([
            'update post' => $post ,
            'message' => 'post updated successfully'
        ],200);

    }

    public function deletePublicPost($id){
        $post = public_post::find($id);
        if ( is_null($post)){
            return response()->json([
                'message' => 'Post you have requested not found !'
            ],400);
        }
        $post->delete();
        return response()->json([
            'message' => 'Post deleted successfully !'
        ],200);
    }
}
