
<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\verificationController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/verify_email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::post('chat/room', [ChatController::class,'messages'])->name('chat/room')->middleware('auth:sanctum');
Route::post('chat/room/message', [ChatController::class,'newMessage'])->name('chat/room/message')->middleware('auth:sanctum');



//,'verified','acceptPermission'
Route::group(['middleware'=>['auth:sanctum']],function(){
    //user
    Route::get('show_volunteer_campaign',[UserController::class,'show_volunteer_campaign'])->name('show_volunteer_campaign');

    Route::get('show_details_of_volunteer_campaign',[UserController::class,'show_details_of_volunteer_campaign'])->name('show_details_of_volunteer_campaign');

    Route::post('volunteer_campaign_request',[UserController::class,'volunteer_campaign_request'])->name('volunteer_campaign_request');

    Route::post('donation_campaign_request',[UserController::class,'donation_campaign_request'])->name('donation_campaign_request');

    Route::post('add_profile',[UserController::class,'add_profile'])->name('add_profile')->middleware('oneProfile');

    Route::post('update_profile',[UserController::class,'update_profile'])->name('update_profile');




    Route::get('show_public_posts',[UserController::class,'show_public_posts'])->name('show_public_posts');

    Route::get('show_posts_of_campaign',[UserController::class,'show_posts_of_campaign'])->name('show_posts_of_campaign');

    Route::get('join_campaign',[UserController::class,'join_campaign'])->name('join_campaign')->middleware('haveProfile');






    //admin
    Route::post('add_volunteer_campaign',[AdminController::class,'add_volunteer_campaign'])->name('add_volunteer_campaign');

    Route::post('update_volunteer_campaign',[AdminController::class,'update_volunteer_campaign'])->name('update_volunteer_campaign');

    Route::delete('delete_volunteer_campaign',[AdminController::class,'delete_volunteer_campaign'])->name('delete_volunteer_campaign');


    Route::get('all_volunteer_campaign_request',[AdminController::class,'all_volunteer_campaign_request'])->name('all_volunteer_campaign_request');

    Route::get('all_donation_campaign_request',[AdminController::class,'all_donation_campaign_request'])->name('all_donation_campaign_request');

    Route::get('all_user_leader_in_future',[AdminController::class,'all_user_leader_in_future'])->name('all_user_leader_in_future');

    Route::post('response_on_volunteer_campaign_request',[AdminController::class,'response_on_volunteer_campaign_request'])->name('response_on_volunteer_campaign_request');


    Route::post('response_on_donation_campaign_request',[AdminController::class,'response_on_donation_campaign_request'])->name('response_on_donation_campaign_request');

    Route::post('add_public_post',[AdminController::class,'add_public_post'])->name('add_public_post');

    Route::post('update_public_Posts',[AdminController::class,'update_public_Posts'])->name('update_public_Posts');

    Route::delete('delete_public_post',[AdminController::class,'delete_public_post'])->name('delete_public_post');




    //leader
    Route::post('add_campaign_post',[LeaderController::class,'add_campaign_post'])->name('add_campaign_post');
});

