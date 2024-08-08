<?php

use App\Models\UserData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SignInController;
use Web3\RequestManagers\HttpRequestManager;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login/{type}',[SignInController::class,'Login'])->name('signin.type');

Route::post('image/stroe',[ImageController::class,'Receive'])->name('image.receipt');
Route::get('/get/data',[ImageController::class,'GetData'])->name('image.get.data');
Route::post('/add/data',[ImageController::class,'AddData'])->name('image.add.data');

// Route::get('random',function(){
//   for($i = 0;$i<18;$i++){
//     $date = date('Y-m-d '.$i.':i:s');
//     $dateCompare = date('Y-m-d H:i:s', strtotime('-'.($i % 14).' days', strtotime($date)));
//     $userData = UserData::where('user_id',1)
//       ->whereDate('created_at',date('Y-m-d ',strtotime($dateCompare)))
//       ->first();
//     if(!$userData){
//       $data = new UserData();
//       $data->sys = rand(80, 180);
//       $data->dia = rand(80, 180);
//       $data->pul = rand(80, 180);
//       $data->user_id = 1;
//       $data->created_at = date('Y-m-d H:i:s', strtotime('-'.($i % 14).' days', strtotime($date)));
//       $data->save();
//     }else{
//       $userData->sys = rand(80, 180);
//       $userData->dia = rand(80, 180);
//       $userData->pul = rand(80, 180);
//       $userData->user_id = 1;
//       $userData->created_at = date('Y-m-d H:i:s', strtotime('-'.($i % 14).' days', strtotime($date)));
//       $userData->update();
//     }
//   }
// });

Route::get('/account/delete/{type}',[SignInController::class,'DeleteAccount'])->name('delete.account');
