<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TokenGenerate;

class APIAuth
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
        // dd($request->header(),$request->header('token'));
        $_token = $request->header('token');
        $sessionId = $request->session_id;
        if(!$sessionId){
            return ['error'=>'this request doesn\'t has session id.'];
        }
        if($_token){
            $token = TokenGenerate::where('token',$_token)->first();
            if($token){
                if($token->expired!= null){
                    $today = date('Y-m-d');
                    $expire = date('Y-m-d',strtotime($token->expired));
                    if($expire< $today){
                        return ['error'=>'your token is expired.'];
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
                if($token->session_id == $sessionId){
                    $dateLogin = date('Y-m-d H:i:s',strtotime('+1 days '.$token->last_login));
                    $dateLoginNow = date('Y-m-d H:i:s');
                    if($dateLogin<$dateLoginNow){
                        $token->session_id = null;
                        $token->update();
                        return ['error'=>'this request is not log in.'];
                    }
                    return $next($request);
                }else{
                    return ['error'=>'the session id is not correct.'];
                }
            }else{
                return ['error'=>'token not found.'];
            }
        }else{
            return ['error'=>'This request is not allowed.'];
        }
    }
}
