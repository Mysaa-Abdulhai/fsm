<?php

namespace App\Http\Middleware;

use App\Models\volunteer;
use Closure;
use Illuminate\Http\Request;

class LeaderInCampaign
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(volunteer::where('volunteer_campaign_id','=',$request->volunteer_campaign_id)
            ->where('user_id','=',auth()->user()->id)
            ->where('is_leader','=',true)
            ->exists())
        {
            return $next($request);
        }
        else
            return response()->json([
                'message'=>'you arn\'t the leader',
            ],403);
    }
}
