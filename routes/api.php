
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\EmailVerificationController;
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
Route::group(['middleware'=>['auth:sanctum']], function () {

    Route::post('test', function() {
        dd(auth()->user());
    });
});

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::delete('/delete_account', [AuthController::class, 'deleteAccount']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Route::post('/email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');


Route::get('/admin',function (Request $request) {
    return('you are admin');
})->middleware('admin','auth:sanctum');
//

Route::get('/go',function () {
    return('you are not an admin');
});

Route::get('/messages', [ChatsController::class,'fetchMessages'])->middleware('auth:sanctum');
Route::post('/messages', [ChatsController::class,'sendMessage'])->middleware('auth:sanctum');



//user
//Route::middleware('auth:sanctum','verified')

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
