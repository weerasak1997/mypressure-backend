<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TokenGenerate;

class APILogin
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
        $_token = $request->header('token');
        if($_token){
            $token = TokenGenerate::where('token',$_token)->first();
            if($token){
                if($token->expired!= null){
                    $today = date('Y-m-d');
                    $expire = date('Y-m-d',strtotime($token->expired));
                    if($expire< $today){
                        return ['error'=>'your token is expired'];
                    }
                }
                $limit = $token->limit;
                $hour = date('H',strtotime($token->last_call));
                $date = date('Y-m-d',strtotime($token->last_call));
                $hourNow = (int)date('H');
                $dateNow = date('Y-m-d');
                if($hour !== $hourNow && $date !== $dateNow){
                    $now = 1;
                    $token->last_call = date('Y-m-d H:i:s');
                }else{
                    $now = $token->now+1;
                }
                if($limit<$now){
                    return ['error'=>'this requests reached a limit.'];
                }
                $token->now = $now;
                $token->update();
                return $next($request);
            }else{
                return ['error'=>'token not found.'];
            }
        }else{
            return ['error'=>'This request is not allowed.'];
        }
    }
}
