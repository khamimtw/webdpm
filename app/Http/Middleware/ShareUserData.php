<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareUserData
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()){
            $user = Auth::user();
            view()->share('user',$user);
        }
        return $next($request);
    }
}
