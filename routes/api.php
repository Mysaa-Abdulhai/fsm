
<?php

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
//Route::group(['middleware'=>['auth:sanctum']], function () {
//
//});
Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::delete('/delete-account', [AuthController::class, 'deleteAccount'])->middleware('auth:sanctum');
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
