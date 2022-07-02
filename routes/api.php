
<?php
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
//Route::group(['middleware'=>['auth:sanctum']], function () {
//
//});
Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::delete('/delete_account', [AuthController::class, 'deleteAccount'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Route::post('/email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:sanctum');


Route::get('/admin',function (Request $request) {
    return('you are admin');
})->middleware('admin','auth:sanctum');
//

Route::get('/notAdmin',function () {
    return('you are not an admin');
});

Route::get('/haveForm',function () {
    return('you have a form');
});

Route::get('/messages', [ChatsController::class,'fetchMessages'])->middleware('auth:sanctum');
Route::post('/messages', [ChatsController::class,'sendMessage'])->middleware('auth:sanctum');



//user
Route::group(['middleware'=>['auth:sanctum','verified']],function(){
    Route::get('/show_volunteer_campaign',[UserController::class,'show_volunteer_campaign']);

    Route::get('/show_details_of_volunteer_campaign',[UserController::class,'show_details_of_volunteer_campaign']);

    Route::post('/volunteer_campaign_request',[UserController::class,'volunteer_campaign_request']);

    Route::post('/donation_campaign_request',[UserController::class,'donation_campaign_request']);

    Route::post('/volunteer_form',[UserController::class,'volunteer_form'])->middleware('doesNotHaveForm');

    Route::get('/show_public_posts',[UserController::class,'show_public_posts']);

    Route::get('/show_posts_of_campaign',[UserController::class,'show_posts_of_campaign']);
});


