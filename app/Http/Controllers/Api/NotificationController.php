<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Helpers\ResponseHelper;
use App\Models\User;

class NotificationController extends Controller
{
    public function sendNotification($data)
    {
        if(count($data)>3){
            $id = $data['id'];
        }
        $role_id = $data['role_id'];
        $message_title = $data['message_title'];
        $message_body = $data['message_body'];
        
        if(count($data)>3){
            $firebaseToken = User::where('id', $id)
                            ->where('roles_id', $role_id)
                            ->whereNotNull('firebase_token')
                            ->pluck('firebase_token')->all();
        }else{
            $firebaseToken = User::where('roles_id', $role_id)
            ->whereNotNull('firebase_token')
            ->pluck('firebase_token')->all();
        }

        // $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');
        $SERVER_API_KEY = "AAAANFXaaRU:APA91bHKN84-5BjM8vGx5T22PH1ThU99HYV_9kUoSys3UhZJqjhis5jEqliqDXfZup_liTn3TD2sxgL6EIovOnaR3ZDwNpdocXp_9wbO6hSz49H0cyFQgkNeFz6SRwqf5dZ1hpqyA_vY";
  
        if($firebaseToken){
            $data = [
                "to" => $firebaseToken[0],
                "notification" => [
                    "title" => $message_title,
                    "body" => $message_body,  
                ]
            ];
            
            $dataString = json_encode($data);
        
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];
        
            $ch = curl_init();
          
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                   
            $response = curl_exec($ch);
        }else{
            $data['message'] = 'Firebase Token Tidak Ditemukan';
            return ResponseHelper::error($data);
        }

        error_log($response);
        dd($response);
    }
}