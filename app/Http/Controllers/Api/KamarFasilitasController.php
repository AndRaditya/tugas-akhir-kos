<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Helpers\ResponseHelper;
use App\Models\KamarFasilitas;

class KamarFasilitasController extends Controller
{
    public function create($data, $id){
        return DB::transaction(function () use ($data, $id){
            $fasilitas['name'] = $data;
            $fasilitas['kamar_id'] = $id;
            
            $kamarFasilitasQuery = KamarFasilitas::updateOrCreate($fasilitas);
            return ResponseHelper::create($kamarFasilitasQuery);
        });
    }

    public function deleteSelected($id){
        KamarFasilitas::where('kamar_id', $id)->delete();
    }
    
}