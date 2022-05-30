<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $permissions = [];
        foreach ($guards as $p => $permission) {
            $permissions[$p] = $request->authUser->permissions->$permission == true;

            if (
                $request->authUser->permissions->users == true &&
                ($permission === 'is_self' &&  $request->has("id"))
            ) {
                $permissions[$p] = $request->id == $request->authUser->id;
            } 
        }

        if (in_array(true, $permissions)) return $next($request);
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
