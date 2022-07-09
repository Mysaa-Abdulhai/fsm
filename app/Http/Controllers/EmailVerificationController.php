<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\user_role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use phpDocumentor\Reflection\Types\Null_;

class EmailVerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {

            return response()->json([
                'message' => 'Email has been verified',
            ],400);
        }
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));

        }
        User::where('id','=',auth()->user()->id)->update(['is_verified'=>true]);
        $user_role= new user_role([
            'user_id'=> auth()->user()->id,
            'role_id'=> 2
        ]);
        $user_role->save();
        return response()->json([
            'message' => 'Email verified',
        ], 201);

    }
}
