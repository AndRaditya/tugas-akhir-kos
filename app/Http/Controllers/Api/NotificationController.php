<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Helpers\ResponseHelper;
use App\Models\User;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $id = $request->id;
        $role_id = $request->role_id;
        $message_title = $request->message_title;
        $message_body = $request->message_body;
        
        if($id){
            $firebaseToken = User::where('id', $id)
                            ->where('roles_id', $role_id)
                            ->whereNotNull('firebase_token')
                            ->pluck('firebase_token')->all();
        }else{
            $firebaseToken = User::where('roles_id', $role_id)
            ->whereNotNull('firebase_token')
            ->pluck('firebase_token')->all();
        }

        $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');
  
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
    }

}