<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->type === 'user'){
                if((!Auth::user()->term||!Auth::user()->UserInfo) && strpos($request->path(),'signup') === false){
                    if(!Auth::user()->term){
                        return redirect()->route('signup.term');
                    }
                    if(!Auth::user()->UserInfo){
                        return redirect()->route('signup.info');
                    }
                }
                return $next($request);
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }
}
