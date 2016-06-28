<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()){
            return $next($request);
        } else {
            if($request->ajax()){
                return response()->json(['msg' => 'Please login'], 401);
            }
            return redirect()->route('home')->with(['flash_message' => 'Please sign in before continuing', 'flash_message_type' => 'warning']);;
        }
    }
}
