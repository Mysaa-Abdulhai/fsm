
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatsController;
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
<<<<<<< HEAD
Route::group(['middleware'=>['auth:sanctum']], function () {

    Route::post('test', function() {
        dd(auth()->user());
    });
});

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
=======
//Route::group(['middleware'=>['auth:sanctum']], function () {
//
//});
Route::middleware(['auth:sanctum','verified'])->get('/user', function (Request $request) {
>>>>>>> 57f92eaa12f7d8ceabd86701bf628f057b4c0de8
    return $request->user();
});




Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::delete('/delete_account', [AuthController::class, 'deleteAccount'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/verify_email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');

Route::get('/messages', [ChatsController::class,'fetchMessages'])->middleware('auth:sanctum');
Route::post('/messages', [ChatsController::class,'sendMessage'])->middleware('auth:sanctum');



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




    //leader

});


<<<<<<< HEAD
Route::get('/show_volunteeer_campaign',[UserController::class,'show_volunteeer_campaign']);
Route::get('/show_details_of_volunteeer_campaign/{id}',[UserController::class,'show_details_of_volunteeer_campaign']);
Route::get('/volunteeer_campaign_request',[UserController::class,'volunteeer_campaign_request']);



Route::post('/add_donation_campaign', [AdminController::class,'add_donation_campaign'])->middleware('auth:sanctum');
Route::post('/add_post' , [AdminController::class,'add_posts']);
Route::delete('/delete_donation_capaign/{id}' ,  [AdminController::class,'deleteDonationCapaign'])->middleware('auth:sanctum');

Route::post('/add_volunteer_campaign', [AdminController::class,'add_volunteer_campaign'])->middleware('auth:sanctum');
Route::post('/update_posts/{id}', [AdminController::class,'updatePosts'])->middleware('auth:sanctum');

Route::group(['middleware'=>['auth:sanctum','verified']],function(){   
    //Route::post('/update_volunteer_vampaign', [AdminController::class,'update_volunteer_vampaign'])->middleware('auth:sanctum');

});
=======
>>>>>>> 57f92eaa12f7d8ceabd86701bf628f057b4c0de8
