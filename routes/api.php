
<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Middleware\DoesNotHaveForm;
use App\Models\leader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','verified'])->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::delete('/delete_account', [AuthController::class, 'deleteAccount'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/verify_email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::post('chat/room', [ChatController::class,'messages'])->name('chat/room')->middleware('auth:sanctum');
Route::post('chat/room/message', [ChatController::class,'newMessage'])->name('chat/room/message')->middleware('auth:sanctum');



Route::group(['middleware'=>['auth:sanctum','verified','acceptPermission']],function(){
    //user
    Route::get('show_volunteer_campaign',[UserController::class,'show_volunteer_campaign'])->name('show_volunteer_campaign');

    Route::get('show_details_of_volunteer_campaign',[UserController::class,'show_details_of_volunteer_campaign'])->name('show_details_of_volunteer_campaign');

    Route::post('volunteer_campaign_request',[UserController::class,'volunteer_campaign_request'])->name('volunteer_campaign_request');

    Route::post('donation_campaign_request',[UserController::class,'donation_campaign_request'])->name('donation_campaign_request');

    Route::post('volunteer_form',[UserController::class,'volunteer_form'])->name('volunteer_form')->middleware('doesNotHaveForm');

    Route::get('show_public_posts',[UserController::class,'show_public_posts'])->name('show_public_posts');

    Route::get('show_posts_of_campaign',[UserController::class,'show_posts_of_campaign'])->name('show_posts_of_campaign');


    //admin
    Route::get('all_volunteer_campaign_request',[AdminController::class,'all_volunteer_campaign_request'])->name('all_volunteer_campaign_request');

    Route::get('all_donation_campaign_request',[AdminController::class,'all_donation_campaign_request'])->name('all_donation_campaign_request');

    Route::get('all_volunteer_form',[AdminController::class,'all_volunteer_form'])->name('all_volunteer_form');

    Route::post('response_on_volunteer_campaign_request',[AdminController::class,'response_on_volunteer_campaign_request'])->name('response_on_volunteer_campaign_request');

    Route::post('determine_leader',[AdminController::class,'determine_leader'])->name('determine_leader');

    Route::post('response_on_donation_campaign_request',[AdminController::class,'response_on_donation_campaign_request'])->name('response_on_donation_campaign_request');

    Route::post('add_posts',[AdminController::class,'add_posts'])->name('add_posts');

    Route::post('updatePosts',[AdminController::class,'updatePosts'])->name('updatePosts');

    Route::delete('deletePublicPost',[AdminController::class,'deletePublicPost'])->name('deletePublicPost');



    //leader
    Route::post('add_campaign_post',[LeaderController::class,'add_campaign_post'])->name('add_campaign_post');
});
