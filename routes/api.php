
<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\verificationController;
use App\Models\volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::middleware(['auth:sanctum','verified'])->get('/user', function (Request $request) {
    return $request->user();
});

//code
Route::post('/register_code', [AuthController::class, 'register_code']);
Route::post('/verify', [verificationController::class, 'verify'])->middleware(['auth:sanctum']);
Route::get('/resend', [verificationController::class, 'resend'])->middleware(['auth:sanctum']);







Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::delete('/delete_account', [AuthController::class, 'deleteAccount'])->middleware('auth:sanctum');
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/verify_email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::post('chat/room', [ChatController::class,'messages'])->name('chat/room')->middleware('auth:sanctum');
Route::post('chat/room/message', [ChatController::class,'newMessage'])->name('chat/room/message')->middleware('auth:sanctum');



//,'verified','acceptPermission'
Route::group(['middleware'=>['auth:sanctum','verified','acceptPermission' ]],function(){
    //user
    Route::get('show_volunteer_campaign',[UserController::class,'show_volunteer_campaign'])->name('show_volunteer_campaign');

    Route::get('show_details_of_volunteer_campaign',[UserController::class,'show_details_of_volunteer_campaign'])->name('show_details_of_volunteer_campaign');

    Route::post('volunteer_campaign_request',[UserController::class,'volunteer_campaign_request'])->name('volunteer_campaign_request')->middleware('haveProfile');

    Route::post('donation_campaign_request',[UserController::class,'donation_campaign_request'])->name('donation_campaign_request')->middleware('haveProfile');

    Route::post('add_profile',[UserController::class,'add_profile'])->name('add_profile')->middleware('oneProfile');

    Route::post('update_profile',[UserController::class,'update_profile'])->name('update_profile');

    Route::get('show_profile',[UserController::class,'show_profile'])->name('show_profile');

    //public post
    Route::get('show_public_posts',[UserController::class,'show_public_posts'])->name('show_public_posts');

    Route::post('add_public_comment',[UserController::class,'add_public_comment'])->name('add_public_comment');

    Route::post('public_post_like',[UserController::class,'public_post_like'])->name('public_post_like');



    //campaign post
    Route::get('show_posts_of_campaign',[UserController::class,'show_posts_of_campaign'])->name('show_posts_of_campaign');

    Route::post('campaign_post_like',[UserController::class,'campaign_post_like'])->name('campaign_post_like');

    //favorite
    Route::post('favorite_campaign',[UserController::class,'favorite_campaign'])->name('favorite_campaign');

    Route::delete('delete_favorite_campaign',[UserController::class,'delete_favorite_campaign'])->name('delete_favorite_campaign');

    Route::get('get_favorite',[UserController::class,'get_favorite'])->name('get_favorite');

    Route::get('join_campaign',[UserController::class,'join_campaign'])->name('join_campaign')->middleware('fullProfile');

    //rate
    Route::post('add_rate',[UserController::class,'add_rate'])->name('add_rate');

    Route::post('update_rate',[UserController::class,'update_rate'])->name('update_rate');

    Route::get('search_name',[UserController::class,'search_name'])->name('search_name');

    //statistics
    Route::get('statistics_likes',[UserController::class,'statistics_likes'])->name('statistics_likes');

    Route::get('statistics_accepted_requests',[UserController::class,'statistics_accepted_requests'])->name('statistics_accepted_requests');

    Route::get('statistics_campaigns',[UserController::class,'statistics_campaigns'])->name('statistics_campaigns');

    Route::post('convert_points_request',[UserController::class,'convert_points_request'])->name('convert_points_request');








    //admin
    Route::post('add_volunteer_campaign',[AdminController::class,'add_volunteer_campaign'])->name('add_volunteer_campaign');

    Route::post('update_volunteer_campaign',[AdminController::class,'update_volunteer_campaign'])->name('update_volunteer_campaign');

    Route::delete('delete_volunteer_campaign',[AdminController::class,'delete_volunteer_campaign'])->name('delete_volunteer_campaign');


    Route::get('all_volunteer_campaign_request',[AdminController::class,'all_volunteer_campaign_request'])->name('all_volunteer_campaign_request');

    Route::get('all_donation_campaign_request',[AdminController::class,'all_donation_campaign_request'])->name('all_donation_campaign_request');

    Route::get('acceptAndUnanswered',[AdminController::class,'acceptAndUnanswered'])->name('acceptAndUnanswered');

    Route::get('all_user_leader_in_future',[AdminController::class,'all_user_leader_in_future'])->name('all_user_leader_in_future');

    Route::post('response_on_volunteer_campaign_request',[AdminController::class,'response_on_volunteer_campaign_request'])->name('response_on_volunteer_campaign_request');


    Route::post('response_on_donation_campaign_request',[AdminController::class,'response_on_donation_campaign_request'])->name('response_on_donation_campaign_request');

    Route::post('add_public_post',[AdminController::class,'add_public_post'])->name('add_public_post');

    Route::post('update_public_Posts',[AdminController::class,'update_public_Posts'])->name('update_public_Posts');

    Route::delete('delete_public_post',[AdminController::class,'delete_public_post'])->name('delete_public_post');

    Route::get('all_convert_points_request',[AdminController::class,'all_convert_points_request'])->name('all_convert_points_request');

    Route::post('response_on_convert_points_request',[AdminController::class,'response_on_convert_points_request'])->name('response_on_convert_points_request');

    Route::get('male_and_female',[AdminController::class,'male_and_female'])->name('male_and_female');

    Route::get('campaigns_in_category',[AdminController::class,'campaigns_in_category'])->name('campaigns_in_category');



    //leader
    Route::post('add_campaign_post',[LeaderController::class,'add_campaign_post'])->name('add_campaign_post')->middleware('leaderInCampaign');

    Route::post('add_points',[LeaderController::class,'add_points'])->name('add_points')->middleware('leaderInCampaign');
});



Route::post('/token_firebase',function(Request $request){
    $SERVER_API_KEY='AAAACIU4Yhk:APA91bGBOKbSvvlUnOYHyUqfcmK6W-iXzn_qh9k636JxcqQsmV1kuGwHnIosditCThJkK4hAmNHjHDK6HjUjNVDto5XZjjpwWjFdRO6czT0IYMNx25ASXMIAB0RWlawPEWeCqfdkSNpE';

    $token_1 = $request->token;

    $data = [

        "registration_ids" => [
            $token_1
        ],

        "notification" => [

            "title" => 'hello',

            "body" => 'fuck u',

            "sound"=> "default"

        ],

    ];

    $dataString = json_encode($data);

    $headers = [

        'Authorization: key=' . $SERVER_API_KEY,

        'Content-Type: application/json',

    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);

    return $response;

});
Route::get('/chart',function(Request $request){
    return response()->json([
        'data' =>
            [
                ['male',2020,200],
                ['female',2020,50],
                ['male',2021,250],
                ['female',2021,4],
                ['male',2022,70],
                ['female',2022,300]
            ]
    ],200);
});




