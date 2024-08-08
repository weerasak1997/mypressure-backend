<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SignInController extends Controller
{
    public function Login(Request $request,$type){
        switch($type){
            case 'gmail': 
                $user = User::where('email',$request->email)->first();
                if(!$user){
                    $user = new User();
                    $user->name = $request->displayName;
                    $user->email = $request->email;
                    $user->type = $type;
                    $user->gmail_id = $request->id;
                    $user->image = $request->photoUrl;
                    $user->token = bin2hex(random_bytes(25));
                    $user->last_login = date('Y-m-d H:i:s');
                    $user->save();
                }
            ;break;
            case 'apple': 
                $user = User::where('token_id',$request->idToken)->first();
                if(!$user){
                    $user = new User();
                    $user->type = $type;
                    $user->token = bin2hex(random_bytes(25));
                    $user->token_id = $request->idToken;
                    $user->last_login = date('Y-m-d H:i:s');
                    $user->save();
                }
            ;break;
        }
        return $user->token;
    }
}
