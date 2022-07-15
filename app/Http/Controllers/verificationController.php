<?php

namespace App\Http\Controllers;
use App\Models\user_role;
use App\Notifications\VerificationCode;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;


class verificationController extends Controller
{

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'integer|required',
        ]);

        $user = auth()->User();

        if($request->verification_code==$user->verification_code)
        {
            $user->update(['is_verified'=>true]);
            $user->update(['email_verified_at'=>Carbon::now()->toDateTimeString()]);
            $user->save();
            $user_role= new user_role([
                'user_id'=> auth()->user()->id,
                'role_id'=> 2
            ]);
            $user_role->save();
            $user->resetCode();
            event(new Verified($request->user));
            return response()->json([
                'message' => 'Email verified',

            ],200 );
        }
        return response()->json([
            'message' => 'The verification code you have entered does not match',

        ],400 );
    }

    public function resend()
    {
        $user = auth()->User();
        $user->generateCode();
        $user->notify(new VerificationCode());
        return response()->json([
            'message' => 'The verification code has been sent again',

        ],200 );
    }
}
