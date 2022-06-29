<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Traits\ApiResponder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use phpDocumentor\Reflection\Types\Null_;

class EmailVerificationController extends Controller
{
    use ApiResponder;
//    public function sendVerificationEmail(Request $request)
//    {
//
//        if ($request->user()->hasVerifiedEmail()) {
//            return [
//                'message' => 'Already Verified'
//            ];
//        }
//
//        $request->user()->sendEmailVerificationNotification();
//
//        return ['status' => 'verification-link-sent'];
//    }

    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->noContentResponse('Email has been verified');
        }
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        return $this->noContentResponse('Email already verified');

        $request->user()->email_verified_at=Carbon::now()->toDateTimeString();

    }
}
