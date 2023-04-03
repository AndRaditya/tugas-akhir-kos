<?php

namespace App\Helpers;

class ResponseHelper
{

    static function get($data) {
        return response()->json(["data" => $data],200);
    }
    
    static function create($id = "not returned") {
        return response()->json(['content' => "created", 'id' => $id],201);
    }
    
    static function put() {
         return response()->json(['content' => "updated"],202);
    }
    
    static function delete() {
        return response()->json(['content' => "deleted"],204);
    }

    static function error($data) {
        if($data["message"] == null || $data["message"] == ""){
            $data["message"] = $data;
        }
        return response()->json($data,412);
    }

}

?>