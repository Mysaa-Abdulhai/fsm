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
        $forms = volunteer_form::where('leaderInFuture','=',true)->get();
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
        $campaign_request = volunteer_campaign_request::where('id', '=', $request->id)->get()   ;
        if ($request->accept) {
            $campaign = new volunteer_campaign();

            $campaign->location_id = $campaign_request->location_id;
            $campaign->image = $campaign_request->image;
            $campaign->details = $campaign_request->details;
            $campaign->type = $campaign_request->type;
            $campaign->name = $campaign_request->name;
            $campaign->volunteer_number = $campaign_request->volunteer_number;
            $campaign->logitude = $campaign_request->longitude;
            $campaign->latitude = $campaign_request->latitude;
            $campaign->maxDate = $campaign_request->maxDate;
            $campaign->save();

            $group=new ChatRoom();
            $group->name=$campaign->name;
            $group->volunteer_campaign_id=$campaign->id;
            $group->save();


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

    public function determine_leader(Request $request)
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
}
