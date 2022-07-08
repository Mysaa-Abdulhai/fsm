<?php

namespace App\Http\Middleware;

use App\Models\volunteer_form;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoesNotHaveForm
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
        $index=auth::user()->id;
        if(volunteer_form::where('user_id',$index)==false)
        {
            return $next($request);
        }
        else
            return response()->json([
                'message' => 'you have a form',
            ],403);
    }
}
