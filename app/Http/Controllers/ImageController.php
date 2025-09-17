<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function Receive(Request $request){
        $_token = $request->header('_token');
        $user = User::where('token',$_token)->first();
        if($user){
            $imageData = $request->input('image1');
            $imageData = base64_decode($imageData);
            $filename = uniqid() . '.png'; // Assuming the image is PNG, adjust as needed
            $path = 'public/upload/' . $filename;
            Storage::put($path, $imageData);
            $path = 'https://mypressure.the8th-floor.com/storage/upload/'. $filename;
            $imageSize = getimagesize($path);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://abc.cv.api.apollo21.asia/api/detect',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "image_url": "'.$path.'",
                "gauge_min": 0.000,
                "gauge_max": 9999999.000,
                "image_width": '.(int)$imageSize[0].',
                "image_height": '.(int)$imageSize[1].',
                "overlay_top": 0,
                "overlay_left": 0,
                "overlay_width": 0,
                "overlay_height": 0,
                "gauge_shape_type": "DIGITAL"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'SECRET_KEY: sdjeilos0383klcehisYJK'
            ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            Log::info($response);
            //delete image1
            Storage::delete($path);
            $response = json_decode($response);
            try {
                if($response != null){
                    if (array_key_exists('result', $response)) {
                        $sys = $response->result;
                    }else{
                        $sys =0;
                    }
                }else{
                    $sys = 0;
                }
            } catch (Exception $e) {
                $sys = 0;
            }
            // image 2
            $imageData = $request->input('image2');
            $imageData = base64_decode($imageData);
            $filename = uniqid() . '.png'; // Assuming the image is PNG, adjust as needed
            $path = 'public/upload/' . $filename;
            Storage::put($path, $imageData);
            $path = 'https://mypressure.the8th-floor.com/storage/upload/'. $filename;
            $imageSize = getimagesize($path);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://abc.cv.api.apollo21.asia/api/detect',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "image_url": "'.$path.'",
                "gauge_min": 0.000,
                "gauge_max": 9999999.000,
                "image_width": '.(int)$imageSize[0].',
                "image_height": '.(int)$imageSize[1].',
                "overlay_top": 0,
                "overlay_left": 0,
                "overlay_width": 0,
                "overlay_height": 0,
                "gauge_shape_type": "DIGITAL"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'SECRET_KEY: sdjeilos0383klcehisYJK'
            ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            Log::info($response);
            //delete image2
            Storage::delete($path);
            $response = json_decode($response);
            try {
                if($response != null){
                    if (array_key_exists('result', $response)) {
                        $dia = $response->result;
                    }else{
                        $dia =0;
                    }
                }else{
                    $dia = 0;
                }
            } catch (Exception $e) {
                $dia = 0;
            }
            // image 3
            $imageData = $request->input('image3');
            $imageData = base64_decode($imageData);
            $filename = uniqid() . '.png'; // Assuming the image is PNG, adjust as needed
            $path = 'public/upload/' . $filename;
            Storage::put($path, $imageData);
            $path = 'https://mypressure.the8th-floor.com/storage/upload/'. $filename;
            $imageSize = getimagesize($path);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://abc.cv.api.apollo21.asia/api/detect',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "image_url": "'.$path.'",
                "gauge_min": 0.000,
                "gauge_max": 9999999.000,
                "image_width": '.(int)$imageSize[0].',
                "image_height": '.(int)$imageSize[1].',
                "overlay_top": 0,
                "overlay_left": 0,
                "overlay_width": 0,
                "overlay_height": 0,
                "gauge_shape_type": "DIGITAL"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'SECRET_KEY: sdjeilos0383klcehisYJK'
            ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            Log::info($response);
            //delete image3
            Storage::delete($path);
            $response = json_decode($response);
            try {
                if($response != null){
                    if (array_key_exists('result', $response)) {
                        $pul = $response->result;
                    }else{
                        $pul =0;
                    }
                }else{
                    $pul = 0;
                }
            } catch (Exception $e) {
                $pul = 0;
            }
            return response()->json(['sys' => $sys,'dia'=>$dia,'pul'=>$pul], 200);
        }
        return response()->json(['message' => 'File upload failed'], 400);
    }
    public function AddData(Request $request){
        $_token = $request->header('_token');
        $user = User::where('token',$_token)->first();
        if($user){
            $date = date('Y-m-d H:i:s');
            $userData = UserData::where('user_id',$user->id)
            ->whereDate('created_at',date('Y-m-d ',strtotime($date)))
            ->first();
            $json = json_decode($request->getContent(), true);
            Log::info($json);
            if(!$userData){
                $data = new UserData();
                $data->sys = $json['sys'];
                $data->dia = $json['dia'];
                $data->pul = $json['pul'];
                $data->user_id = $user->id;
                $data->created_at = date('Y-m-d H:i:s');
                $data->save();
            }else{
                $userData->sys = $json['sys'];
                $userData->dia = $json['dia'];
                $userData->pul = $json['pul'];
                $userData->user_id = $user->id;
                $userData->created_at = date('Y-m-d H:i:s');
                $userData->update();
            }
            // get dataArray
            $now = date('Y-m-d H:i:s');
            $limit = date('Y-m-d H:i:s',strtotime('-14 days '.$now));
            $datas = UserData::where('user_id',$user->id)
            ->where('created_at','>=',$limit)
            ->take(14)
            ->get();
            $array = [];
            $index = 0;
            $dayNow = date('Y-m-d H:i:s');
            if(count($datas)>0){
                for($i = 0;$i<14;$i++){
                    $dayShow = date('d',strtotime('-'.$i.' days '.$dayNow));
                    $dayData = date('Y-m-d H:i:s',strtotime('-'.$i.' days '.$dayNow));
                    if(count($datas)>$index){
                        $day = date('d',strtotime($datas[$index]->created_at));
                    }else{
                        $day = -1;
                    }
                    // echo $dayShow." <=> ".$day.'\n';
                    if($day == $dayShow){
                        array_push($array,$datas[$index]);
                        $index++;
                    }else{
                        array_push($array,["id"=> '-', "sys"=> 0, "dia"=> 0, "pul"=> 0, "user_id"=> 1, "created_at"=> $dayData, "updated_at"=>$dayData]);
                    }
                }
            }else{
                for($i = 0;$i<14;$i++){
                    $dayShow = date('d',strtotime('-'.$i.' days '.$dayNow));
                    $dayData = date('Y-m-d H:i:s',strtotime('-'.$i.' days '.$dayNow));
                    array_push($array,["id"=> '-', "sys"=> 0, "dia"=> 0, "pul"=> 0, "user_id"=> 1, "created_at"=> $dayData, "updated_at"=>$dayData]);
                }
            }
            array_reverse($array);
            return response()->json($array);
        }
        return response()->json(['message' => 'Add data failed'], 400);
    }
    public function GetData(Request $request){
        $_token = $request->header('_token');
        $user = User::where('token',$_token)->first();
        if($user){
            $now = date('Y-m-d H:i:s');
            $limit = date('Y-m-d H:i:s',strtotime('-14 days '.$now));
            $datas = UserData::where('user_id',$user->id)
            ->where('created_at','>=',$limit)
            ->take(14)
            ->get();
            $array = [];
            $index = 0;
            $dayNow = date('Y-m-d H:i:s');
            if(count($datas)>0){
                for($i = 0;$i<14;$i++){
                    $dayShow = date('d',strtotime('-'.$i.' days '.$dayNow));
                    $dayData = date('Y-m-d H:i:s',strtotime('-'.$i.' days '.$dayNow));
                    if(count($datas)>$index){
                        $day = date('d',strtotime($datas[$index]->created_at));
                    }else{
                        $day = -1;
                    }
                    // echo $dayShow." <=> ".$day.'\n';
                    if($day == $dayShow){
                        array_push($array,$datas[$index]);
                        $index++;
                    }else{
                        array_push($array,["id"=> '-', "sys"=> 0, "dia"=> 0, "pul"=> 0, "user_id"=> 1, "created_at"=> $dayData, "updated_at"=>$dayData]);
                    }
                }
            }else{
                for($i = 0;$i<14;$i++){
                    $dayShow = date('d',strtotime('-'.$i.' days '.$dayNow));
                    $dayData = date('Y-m-d H:i:s',strtotime('-'.$i.' days '.$dayNow));
                    array_push($array,["id"=> '-', "sys"=> 0, "dia"=> 0, "pul"=> 0, "user_id"=> 1, "created_at"=> $dayData, "updated_at"=>$dayData]);
                }
            }
            // array_reverse($array);
            return response()->json($array);
        }
        // $_token = $request->header('_token');
        // $user = User::where('token',$_token)->first();
        // if($user){
        //     $now = date('Y-m-d H:i:s');
        //     $limit = date('Y-m-d H:i:s',strtotime('-14 days '.$now));
        //     $data = UserData::where($user->id)
        //     ->where('created_at','>=',$limit)
        //     ->get();
        // }
        // return response()->json(['message' => 'File get data failed'], 400);
    }
}
