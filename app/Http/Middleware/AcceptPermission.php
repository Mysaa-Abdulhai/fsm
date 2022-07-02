<?php

namespace App\Http\Middleware;

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
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user=auth()->user()->id;
        $userRole=user_role::select('role_id')->where('user_id','=',$user)->get();
        $permissionName=$request->route()->getName();
        $in=false;
        foreach ($userRole as $role) {
                $rule=Role::where('id','=',$role);
                if($rule->check($permissionName))
                    $in=true;
        }
        if($in==true)
            return $next($request);
        else
            return $this->response()->json([
                'message' => 'access denied'
            ]);
    }
}
