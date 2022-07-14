<?php

namespace App\Http\Middleware;

use App\Models\Profile;
use Closure;
use Illuminate\Http\Request;

class HaveProfile
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
                'message' => 'you havn\'t profile',
            ],403);
        }
        $pro=Profile::where('user_id','=',auth()->user()->id)->first();
//        if($pro::whereNull(['nationality','study','skills',
//                'leaderInFuture','phoneNumber','city','country','street'])==false)
        if($pro->nationality==null
        &&$pro->study==null
        &&$pro->skills==null
        &&$pro->leaderInFuture==null
        &&$pro->phoneNumber==null
        &&$pro->city==null
        &&$pro->country==null
        &&$pro->street==null)
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
