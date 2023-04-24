<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\URL;

class FileHandlerService
{

    public function storage($fileString,$folder="uploads",String $oldFile=null) {
        if(!!$oldFile){
            $oldFileName = explode('/', $oldFile);
            $oldName = explode('.',$oldFileName[count($oldFileName) - 1]);
            $fileName = $this->generateNameFile().".".$oldName[count($oldName)-1];
            $path = $folder."/".$oldFileName[count($oldFileName) - 1];
            if (Storage::exists("/public/".$path)) {
                Storage::delete("/public/".$path);
            }
        }else{
            $extString = explode(';', $fileString);
            error_log($extString[0]);
            $ext = explode('/',$extString[0]);
            error_log($ext[1]);
            $fileName = $this->generateNameFile().".".$ext[1];
        }
        $file = Explode(',',$fileString);
        $path = $folder."/".$fileName;

        
        Storage::put("/public/".$path,base64_decode($file[1]),'public');

        return URL::to('/storage/'.$path);
    } 


    public function generateNameFile() {
        
        return md5(microtime());

    }



}