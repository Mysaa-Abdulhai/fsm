<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Profile;
use App\Models\Donation_campaign;
use App\Models\Campaign_volunteer;
use App\Models\Archived_Compaign;
use App\Http\Controllers\add_donation_campaign ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB ;
use Illuminate\Validation\Validator\validateLongText;
use App\Models\volunteer_campaign_request;
use Exception;
use Illuminate\QueryException ;

use App\Models\location;
class AdminController extends Controller{

    public function add_volunteer_campaign(Request $request){      
        // try{
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string',
            'type'       => 'required|string',
            'details'    => 'required|string|min:5',
            'target'     => 'required|string',
            'maxDate'    => 'required',
            'volunteer_number' => 'required|numeric',
            'leader_id'  => 'required|numeric' ,
            'location_id' => 'required|numeric' ,
            'photo'      => 'nullable|image:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
    
        if ($validator->fails())
            return response()->json($validator->errors()->toJson(), 400);
    
        $location=new location();
        $location->country = $request->country;
        $location->city    = $request->city;
        $location->street  = $request->street;
        $location->save();

        dd(auth()->user());

        $new_campaign = new Campaign_volunteer();
        $new_campaign->name     = $request->name ;
        $new_campaign->type     = $request->type ;
        $new_campaign->details  = $request->details ;
        $new_campaign->target   = $request->target ;
        $new_campaign->volunteer_number = $request->volunteer_number  ;
        $new_campaign->maxDate  = $request->maxDate ;   
        $new_campaign->location_id      =$location->id;
        $new_campaign->photo_id = $request->photo_id ;
        $new_campaign->user_id  = auth()->user()->id;
        $new_campaign->save() ;
        

        return response()->json([
            'message'  => 'campaign added Successfully',
            'campaign'  => $new_campaign,
        ],200);
           
        //} catch(\Exception){
        //     return response()->json([
        //         'error'
        //     ],400);
        //}
    }//end


    public function add_donation_campaign(Request $request){
        //try{   
            $validator = Validator::make($request->all(), [
                'name'        => 'required|string' ,
                'description' => 'required|string' ,
                'total_value' => 'required|int'    ,
                'maxDate'     => 'required'        ,
                'photo'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'          ,
            ]);
  
            if ($validator->fails()){
                return response()->json([$validator->getMessageBag()], 400);
            }
  
           //dd(auth()->user());
            $new_campaign = new donation_campaign();
            $new_campaign->name         = $request->name;
            $new_campaign->description  = $request->description;
            $new_campaign->total_value  = $request->total_value;
            $new_campaign->maxDate      = $request->maxDate;
            $new_campaign->user_id      = auth()->user()->id;
            $new_campaign->image      = $request->photo;
            $new_campaign->donation_campaign_request_id =  $request->donation_campaign_request_id;
            $new_campaign->save();
  
            //dd($new_campaign);
            return response()->json([ 
                'message'  => 'campaign added Successfully',
                'campaign'  => $new_campaign,
            ],200);
      
        // }catch(Exception) {
        //     return response()->json([
         //     $request->errors()]);
        // }
    } //end 



    ///Add Posts 
    public function add_posts(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body'  => 'required|string' ,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'             
            ]);

            if ($validator->fails()){
                return response()->json([
                    'error',
                    $validator->getMessageBag()
                ],400);
            }

            $new_post = new Posts();
            $new_post->title = $request->title ;
            $new_post->body  = $request->body ;
            $new_post->photo = $request->photo ;
            $new_post->save();

            return response()->json([
                'post'    => $new_post,
                'message' => 'Post added Successfully'
            ],200);
    }


    // update Posts
    public function updatePosts(Request $request,$id){   

        $update_poste = $request->id ;
        $poste_id = Posts::find($update_poste); 
        dd($poste_id);

        if($update_poste == Posts::find($id)){

            $photoUrl=$request->photo==null?null:$this->uploadImage($request);
        
            $validator = Validator::make($request->all(),[
                'title' => 'required|string' ,
                'body'  => 'required|string' ,
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' 
            ]);
                        
        
            if ($validator->fails()){
                return response()->json([
                    'message' => 'pleas Enter an info to update !'
                ],400);
            }
            // dd($validator->getMessageBag());

            $title = $request->title ;
            $body  = $request->body ;          
            $photo = $photoUrl ;

        
            if(! is_null($title))
            $update_poste->title = $title;
        
            if(! is_null($body))
            $update_poste->body = $body;
        

            if(! is_null($photo))
            $update_poste->photo = $photo;

            // dd($update_poste);
            $update_poste->save();

      
            return response()->json([
                'update campaign' => $update_poste,
                'message' => 'campaign updated successfully' 
            ],400);
        }

        return response()->json([
            'message' => 'Post you have requested not found'
        ]);
     

    }///end



    private function uploadImage(Request $request){
        $getImage = $request->photo;
        $imageName = time().'.'.$getImage->extension();
        $imagePath = public_path(). '/campaign/image';

        $getImage->move($imagePath, $imageName);

        return '/campaign/image'.$imageName ; 
    }  //end


    // Delete Capaign
    public function deleteDonationCapaign(Request $request,$id){
        try{ 
        $campaign = Donation_campaign::finid($id);
        dd($campaign);
        if(is_null($campaign)){
            return response()->json([
                $request->eerors()->all(),
                'message' => 'The campaign you have requested is not found'
            ]);
           }

        $campaign->delete() ;
        return response()->json('Campaign has been deleted Successfully!');
        }catch(Exception) {
            return response()->json([
             $request->errors()]);
        }
    }//end


    // response On Campaign Request

        public function response_on_campaign_request(Request $request){
           
            $campaign_requests = volunteer_campaign_request::all();
            $accept = false ;
            foreach($campaign_requests as $campaign_request){
                if($accept){
                    return response()->add_donation_campaign($campaign_request);
                }
                if(!$accept){
                    return response()->archived_compaigns($campaign_request) ;
                }
            }

        }

        public function archived_compaigns(Request $request){

            // $validator = Validator::make($request->all(), [
            //     'name_campaign' => 'required|string' ,
            // ]);
            $new_archived_compaigns = new Archived_Compaign() ;
            $new_archived_compaigns->name_campaign = $request->name_campaign;
            $new_archived_compaigns->volunteer_campaign_request_id = $request->volunteer_campaign_request_id ;
            $new_archived_compaigns->user_id = $request->auth()->user()->id;

            $new_archived_compaigns->save();
    
            return response()->json([ 
                'message'  => 'Request saved as Archived campaign'
            ],200);
        }


        // public function determine_leader_of_campaign(Request $request,$id){

        // }

        public function show_profile(Request $request){
           
            $profiles = Profile::getall();
               
               return response()->json([
                   'profile' => $profiles ,
                   'message' => 'all posts for campaign number'
               ],200);
        }
    
}