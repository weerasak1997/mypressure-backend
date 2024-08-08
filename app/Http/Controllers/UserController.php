<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function EditProfile(Request $request){
      $user = User::find(Auth::user()->id);
      $user->email = $request->email;
      $user->update();
      $user = UserInfo::find($request->id);
      $user->firstname = $request->firstname;
      $user->lastname = $request->lastname;
      $user->birthday = implode("-",array_reverse(explode("/",$request->birthday)));
      $user->gender = $request->gender;
      $user->address1 = $request->address1;
      $user->address2 = $request->address2;
      $user->sub_district_id = $request->subdistrict;
      $user->district_id = $request->district;
      $user->province_id = $request->province;
      $user->sub_district_send_id = $request->subdistrictSend;
      $user->district_send_id = $request->districtSend;
      $user->province_send_id = $request->provinceSend;
      $user->update();
      return redirect()->back();
    }
    public function ChangePassword(Request $request){
      if($request->password){
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->update();
        return redirect()->back();
      }
    }
    public function Search(Request $request){
      $search = $request->search;
      return User::select('users.id',DB::raw('concat(user_infos.firstname," ",user_infos.lastname," (",users.phone,")") as name'))
                  ->leftJoin('user_infos','users.id','user_infos.user_id')
                  ->when($search != null,function($q)use($search){
                    return $q->where(DB::raw('concat(user_infos.firstname," ",user_infos.lastname," (",users.phone,")")'),'like','%'.$search.'%');
                  })
                  ->has('UserInfo')
                  ->get();  
    }
}
