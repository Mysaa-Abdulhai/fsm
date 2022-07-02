<?php

namespace App\Http\Controllers;
use App\Models\volunteer_form;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\photo;
use App\Models\User;
use App\Models\volunteer_campaign_request;
use App\Models\donation_campaign_request;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponder;
use phpDocumentor\Reflection\Types\Boolean;
use App\Models\volunteer_campaign;
use App\Models\location;
class UserController extends Controller
{
    use ApiResponder;
    public function show_volunteer_campaign(Request $request){
        $campaign=volunteer_campaign::all();
        return $this->okResponse($campaign);
    }

    public function show_details_of_volunteer_campaign(Request $request){
        $validator = Validator::make($request->all(), [
            'id'     => 'required|int',
        ]);
        if ($validator->fails())
            return $this->errorResponse($validator->getMessageBag());
        $campaign = volunteer_campaign::where('id',$request->id)->first();
//        $campaign=DB::select('campaign from volunteer_campaign where id ==$id');
        $response = [
            'campaign'  => $campaign,
        ];
        return $this->okResponse($response);
    }
    public function volunteer_campaign_request(Request $request){
        $validator= Validator::make($request->all(), [
            'details'=>'required|string',
            'type'     => 'required|string',
            'volunteer_number'     => 'required|int',
            'target'     => 'required|string',
            'maxDate'     => 'required|date',
            'src'=>'string',
            'country'  => 'required|string',
            'city'  => 'required|string',
            'street'  => 'required|string',

        ]);
        if ($validator->fails())
            return $this->errorResponse($validator->getMessageBag());
        $photo=new Photo();
        $photo->src=$request->src;

        $photo->save();

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
        $campaign_request->user_id=auth()->user()->id;
        $campaign_request->photo_id=$photo->id;
        $campaign_request->location_id=$location->id;

        $response = [
            'campaign_request'  => $campaign_request,
        ];
        return $this->okResponse($response,'request added Successfully');
    }

    public function donation_campaign_request(Request $request){
        $validator= Validator::make($request->all(), [
            'name'=>'required|string',
            'description'     => 'required|string',
            'total_value'     => 'required|int',
            'maxDate'     => 'required|date',
            'src'=>'string',
        ]);
        if ($validator->fails())
            return $this->errorResponse($validator->getMessageBag());
        $photo=new Photo();
        $photo->src=$request->src;

        $photo->save();

        $campaign_request=new donation_campaign_request();
        $campaign_request->name=$request->name;
        $campaign_request->description =$request->description;
        $campaign_request->total_value=$request->total_value;
        $campaign_request->maxDate=$request->maxDate;
        $campaign_request->user_id=auth()->user()->id;
        $campaign_request->photo_id=$photo->id;


        $response = [
            'campaign_request'  => $campaign_request,
        ];
        return $this->okResponse($response,'request added Successfully');
    }

    public function volunteer_form(Request $request){
        $validator=Validator::make($request->all(),[
                'name' => 'required|string|unique:volunteer_forms,name',
                'age' => 'required|int',
                'nationality' => 'required|string',
                'study' => 'required|string',
                'skills' => 'required|string',
                'phoneNumber' => 'required|int|unique:volunteer_forms,phoneNumber',
                'country' => 'required|string',
                'city' => 'required|string',
                'street' => 'required|string',
          ]);

        if ($validator->fails())
            return $this->errorResponse($validator->getMessageBag());

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
        $volunteer_form->location_id=$location->id;
        $volunteer_form->user_id=auth()->user()->id;

        $response = [
            'volunteer_form'  => $volunteer_form,
        ];
        return $this->okResponse($response,'form added Successfully');
    }

    public function show_public_posts(Request $request){

    }

    public function show_posts_of_campaign(Request $request, $id){

    }
}
