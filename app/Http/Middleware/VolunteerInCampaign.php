<?php

namespace App\Http\Middleware;

use App\Models\volunteer;
use Closure;
use Illuminate\Http\Request;

class VolunteerInCampaign
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
        $campaigns=volunteer::where('user_id','=',auth()->user()->id)->pluck('volunteer_campaign_id');

        if($campaigns->contains($request->id)) {
            return $next($request);
        }
        else
            return response()->json([
                'message'  => 'you arn\'t a member in campaign',
            ],403);
    }
}
