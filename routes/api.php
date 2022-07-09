
<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Middleware\DoesNotHaveForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::group(['middleware'=>['auth:sanctum']], function () {
//
//});
Route::middleware(['auth:sanctum','verified'])->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::delete('/delete_account', [AuthController::class, 'deleteAccount'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/verify_email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::get('chat/room', [ChatController::class,'messages'])->name('chat/room')->middleware('auth:sanctum');
Route::post('chat/room/message', [ChatController::class,'newMessage'])->name('chat/room/message')->middleware('auth:sanctum');



Route::group(['middleware'=>['auth:sanctum','verified','acceptPermission']],function(){
    //user
    Route::get('show_volunteer_campaign',[UserController::class,'show_volunteer_campaign'])->name('show_volunteer_campaign');

    Route::get('show_details_of_volunteer_campaign',[UserController::class,'show_details_of_volunteer_campaign'])->name('show_details_of_volunteer_campaign');

    Route::post('volunteer_campaign_request',[UserController::class,'volunteer_campaign_request'])->name('volunteer_campaign_request');

    Route::post('donation_campaign_request',[UserController::class,'donation_campaign_request'])->name('donation_campaign_request');

    Route::post('volunteer_form',[UserController::class,'volunteer_form'])->name('volunteer_form')->middleware('doesNotHaveForm');

    Route::get('show_public_posts',[UserController::class,'show_public_posts'])->name('show_public_posts');

//    Route::get('show_posts_of_campaign',[UserController::class,'show_posts_of_campaign'])->name('show_posts_of_campaign');


    //admin




    //leader
    Route::post('add_campaign_post',[LeaderController::class,'add_campaign_post'])->name('add_campaign_post');
});

Route::post('add_campaign_post',[LeaderController::class,'add_campaign_post'])->name('add_campaign_post')->middleware('auth:sanctum');
Route::get('show_posts_of_campaign',[UserController::class,'show_posts_of_campaign'])->name('show_posts_of_campaign')->middleware('auth:sanctum');

