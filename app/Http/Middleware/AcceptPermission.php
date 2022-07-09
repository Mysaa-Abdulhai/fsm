<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;
use App\Models\user_role;
use Closure;
use Illuminate\Http\Request;

class AcceptPermission
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
        $permissionName=$request->route()->getName();
        $user_role=user_role::where('user_id','=',auth()->user()->id)->get();
        foreach ($user_role as $x)
        {
            if(Permission::query()->where('name','=',$permissionName)->where('role_id','=',$x->role_id)->exists())
                return $next($request);
        }
        return response()->json([
            'message' => 'Access Denied',
        ],403);
    }
}
