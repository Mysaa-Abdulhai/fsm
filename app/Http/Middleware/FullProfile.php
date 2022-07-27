<?php

namespace App\Http\Middleware;

use App\Models\Profile;
use App\Models\profileSkill;
use Closure;
use Illuminate\Http\Request;

class FullProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Profile::where('user_id','=',auth()->user()->id)->exists()!=true)
        {
            return response()->json([
                'message' => 'you haven\'t profile',
            ],403);
        }
        $pro=Profile::where('user_id','=',auth()->user()->id)->first();
        $skill=profileSkill::where('Profile_id','=',$pro->id)->exists();
        if($pro->nationality==null
        &&$pro->gender==null
        &&$skill==false
        &&$pro->birth_date==null
        &&$pro->leaderInFuture==null
        &&$pro->phoneNumber==null
        )
        {
            return response()->json([
                'message' => 'you have to fill all your profile',
            ],403);
        }
        else
        {

            return $next($request);
        }

    }
}
