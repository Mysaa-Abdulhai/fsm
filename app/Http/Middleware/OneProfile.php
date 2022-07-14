<?php

namespace App\Http\Middleware;

use App\Models\Profile;
use Closure;
use Illuminate\Http\Request;

class OneProfile
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
        if(Profile::where('user_id','=',auth()->user()->id)->exists()==true)
        {
            return response()->json([
                'message' => 'you already have a profile',
            ],403);
        }
        else
            return $next($request);
    }
}
